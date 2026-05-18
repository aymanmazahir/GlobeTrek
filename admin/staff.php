<?php
$_title = 'Admin Staff - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['action']) && $_POST['action'] === 'add_staff'){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if($name && $email && $password){
      $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash,role,created_at) VALUES (?,?,?,?,NOW())');
      $stmt->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), 'staff']);
      $message = 'Staff account created successfully.';
    } else {
      $message = 'Please complete all staff fields.';
    }
  }
  if(isset($_POST['action']) && $_POST['action'] === 'edit_staff' && isset($_POST['staff_id'])){
    $staffId = (int) $_POST['staff_id'];
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if($name && $email){
      if($password){
        $pdo->prepare('UPDATE users SET name = ?, email = ?, password_hash = ? WHERE id = ? AND role = ?')
            ->execute([$name, $email, password_hash($password, PASSWORD_BCRYPT), $staffId, 'staff']);
      } else {
        $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ? AND role = ?')
            ->execute([$name, $email, $staffId, 'staff']);
      }
      $message = 'Staff account updated successfully.';
    } else {
      $message = 'Name and email are required for updates.';
    }
  }
  if(isset($_POST['action']) && $_POST['action'] === 'delete_staff' && isset($_POST['staff_id'])){
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ? AND role = ?');
    $stmt->execute([(int)$_POST['staff_id'], 'staff']);
    $message = 'Staff account removed.';
  }
}

$staffMembers = $pdo->prepare('SELECT id,name,email,created_at FROM users WHERE role = ? ORDER BY created_at DESC');
$staffMembers->execute(['staff']);
$staffMembers = $staffMembers->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="admin-action-row">
    <div>
      <span class="section-label">Staff management</span>
      <h2>Add and control staff accounts</h2>
      <p>Create new staff users, edit existing staff details, and manage access centrally.</p>
    </div>
    <button class="button" data-modal-open="#modalAddStaff" data-modal-title="Create staff account">Add staff</button>
  </div>
  <?php if($message): ?><div class="page-alert"><?= htmlspecialchars($message) ?></div><?php endif ?>
  <div class="page-panel">
    <table class="admin-table">
      <thead>
        <tr><th>Name</th><th>Email</th><th>Joined</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php foreach($staffMembers as $staff): ?>
          <tr>
            <td><?= htmlspecialchars($staff['name']) ?></td>
            <td><?= htmlspecialchars($staff['email']) ?></td>
            <td><?= htmlspecialchars($staff['created_at']) ?></td>
            <td>
              <button class="button small ghost" data-modal-open="#modalEditStaff-<?= htmlspecialchars($staff['id']) ?>" data-modal-title="Manage staff account">Manage</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</section>

<template id="modalAddStaff">
  <form method="post">
    <input type="hidden" name="action" value="add_staff">
    <div class="field"><label>Name</label><input name="name" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Password</label><input name="password" type="password" required></div>
    <div class="field"><button class="button" type="submit">Create staff account</button></div>
  </form>
</template>

<?php foreach($staffMembers as $staff): ?>
<template id="modalEditStaff-<?= htmlspecialchars($staff['id']) ?>">
  <form method="post">
    <input type="hidden" name="action" value="edit_staff">
    <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staff['id']) ?>">
    <div class="field"><label>Name</label><input name="name" value="<?= htmlspecialchars($staff['name']) ?>" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" value="<?= htmlspecialchars($staff['email']) ?>" required></div>
    <div class="field"><label>New password <small>(leave blank to keep current)</small></label><input name="password" type="password"></div>
    <div class="field"><button class="button" type="submit">Save changes</button></div>
  </form>
  <form method="post" style="margin-top:1rem">
    <input type="hidden" name="action" value="delete_staff">
    <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staff['id']) ?>">
    <button class="button small ghost" type="submit">Delete staff account</button>
  </form>
</template>
<?php endforeach ?>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>