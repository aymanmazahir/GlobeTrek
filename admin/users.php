<?php
$_title = 'Admin Users - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['action'])){
    if($_POST['action'] === 'add_user'){
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $role = $_POST['role'] ?? 'customer';
      $password = $_POST['password'] ?? '';
      if($name && $email && $password){
        try {
          $pdo->beginTransaction();
          $stmt = $pdo->prepare('INSERT INTO users (email, password_hash, role, created_at) VALUES (?, ?, ?, NOW())');
          $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT), $role]);
          $userId = $pdo->lastInsertId();
          
          if ($role === 'staff') {
            $stmtStaff = $pdo->prepare('INSERT INTO staff (user_id, full_name) VALUES (?, ?)');
            $stmtStaff->execute([$userId, $name]);
          } else {
            $stmtCustomer = $pdo->prepare('INSERT INTO customers (user_id, full_name) VALUES (?, ?)');
            $stmtCustomer->execute([$userId, $name]);
          }
          
          $pdo->commit();
          $message = 'New user added successfully.';
        } catch (Exception $e) {
          $pdo->rollBack();
          $message = 'Error adding user: ' . $e->getMessage();
        }
      } else {
        $message = 'Please complete all user fields.';
      }
    } elseif($_POST['action'] === 'edit_user' && isset($_POST['user_id'])){
      $userId = (int) $_POST['user_id'];
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $role = $_POST['role'] ?? 'customer';
      $password = $_POST['password'] ?? '';
      if($name && $email){
        try {
          $pdo->beginTransaction();
          
          // Get current user role
          $getRole = $pdo->prepare('SELECT role FROM users WHERE id = ?');
          $getRole->execute([$userId]);
          $oldRole = $getRole->fetchColumn();
          
          if ($password) {
            $pdo->prepare('UPDATE users SET email = ?, role = ?, password_hash = ? WHERE id = ? AND role != ?')
                ->execute([$email, $role, password_hash($password, PASSWORD_BCRYPT), $userId, 'admin']);
          } else {
            $pdo->prepare('UPDATE users SET email = ?, role = ? WHERE id = ? AND role != ?')
                ->execute([$email, $role, $userId, 'admin']);
          }
          
          // If role changed, delete from old profile table and insert into new one
          if ($oldRole && $oldRole !== $role) {
            if ($oldRole === 'staff') {
              $pdo->prepare('DELETE FROM staff WHERE user_id = ?')->execute([$userId]);
            } else {
              $pdo->prepare('DELETE FROM customers WHERE user_id = ?')->execute([$userId]);
            }
          }
          
          // Update or Insert in appropriate table
          if ($role === 'staff') {
            $check = $pdo->prepare('SELECT COUNT(*) FROM staff WHERE user_id = ?');
            $check->execute([$userId]);
            if ($check->fetchColumn() > 0) {
              $pdo->prepare('UPDATE staff SET full_name = ? WHERE user_id = ?')->execute([$name, $userId]);
            } else {
              $pdo->prepare('INSERT INTO staff (user_id, full_name) VALUES (?, ?)')->execute([$userId, $name]);
            }
          } else {
            $check = $pdo->prepare('SELECT COUNT(*) FROM customers WHERE user_id = ?');
            $check->execute([$userId]);
            if ($check->fetchColumn() > 0) {
              $pdo->prepare('UPDATE customers SET full_name = ? WHERE user_id = ?')->execute([$name, $userId]);
            } else {
              $pdo->prepare('INSERT INTO customers (user_id, full_name) VALUES (?, ?)')->execute([$userId, $name]);
            }
          }
          
          $pdo->commit();
          $message = 'User account updated.';
        } catch (Exception $e) {
          $pdo->rollBack();
          $message = 'Error updating user: ' . $e->getMessage();
        }
      } else {
        $message = 'Name and email are required.';
      }
    } elseif($_POST['action'] === 'delete_user' && isset($_POST['user_id'])){
      $pdo->prepare('DELETE FROM users WHERE id = ? AND role != ?')->execute([(int) $_POST['user_id'], 'admin']);
      $message = 'User removed.';
    }
  }
}

$usersStmt = $pdo->prepare('
  SELECT u.id, u.email, u.role, u.created_at, 
         COALESCE(c.full_name, s.full_name) AS name 
  FROM users u 
  LEFT JOIN customers c ON c.user_id = u.id 
  LEFT JOIN staff s ON s.user_id = u.id 
  WHERE u.role != ? 
  ORDER BY u.created_at DESC
');
$usersStmt->execute(['admin']);
$users = $usersStmt->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="admin-action-row">
    <div>
      <span class="section-label">User management</span>
      <h2>Manage all accounts</h2>
      <p>Review registered users, update roles, and add new accounts from the admin panel.</p>
    </div>
    <button class="button" data-modal-open="#modalAddUser" data-modal-title="Create new user">Add user</button>
  </div>
  <?php if($message): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(window.showToast) window.showToast(<?= json_encode($message) ?>, 'success');
        });
    </script>
  <?php endif ?>
  <div class="page-panel">
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php foreach($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['created_at']) ?></td>
            <td>
              <button class="button small ghost" data-modal-open="#modalEditUser-<?= htmlspecialchars($user['id']) ?>" data-modal-title="Manage user account">Manage</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</section>

<template id="modalAddUser">
  <form method="post">
    <input type="hidden" name="action" value="add_user">
    <div class="field"><label>Name</label><input name="name" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Role</label><select name="role"><option value="customer">Customer</option><option value="staff">Staff</option></select></div>
    <div class="field"><label>Password</label><input name="password" type="password" required></div>
    <div class="field"><button class="button" type="submit">Create new user</button></div>
  </form>
</template>

<?php foreach($users as $user): ?>
<template id="modalEditUser-<?= htmlspecialchars($user['id']) ?>">
  <form method="post">
    <input type="hidden" name="action" value="edit_user">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
    <div class="field"><label>Name</label><input name="name" value="<?= htmlspecialchars($user['name']) ?>" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" value="<?= htmlspecialchars($user['email']) ?>" required></div>
    <div class="field"><label>Role</label><select name="role"><option value="customer"<?= $user['role'] === 'customer' ? ' selected' : '' ?>>Customer</option><option value="staff"<?= $user['role'] === 'staff' ? ' selected' : '' ?>>Staff</option></select></div>
    <div class="field"><label>New password <small>(leave blank to keep current)</small></label><input name="password" type="password"></div>
    <div class="field"><button class="button" type="submit">Save changes</button></div>
  </form>
  <form method="post" style="margin-top:1rem">
    <input type="hidden" name="action" value="delete_user">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
    <button class="button small ghost" type="submit">Delete user</button>
  </form>
</template>
<?php endforeach ?>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>