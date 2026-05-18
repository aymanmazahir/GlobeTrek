<?php
$_title = 'Login - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
$error = isset($_GET['error']);
$registered = isset($_GET['registered']);
?>

<style>
  .auth-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    padding: 3rem 1rem;
    position: relative;
    overflow: hidden;
  }
  .auth-bg-glow {
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(0, 167, 255, 0.12) 0%, transparent 70%);
    filter: blur(60px);
    z-index: 1;
    pointer-events: none;
    animation: pulseGlow 10s ease-in-out infinite alternate;
  }
  @keyframes pulseGlow {
    0% { transform: translate(-10%, -10%) scale(1); }
    100% { transform: translate(10%, 10%) scale(1.2); }
  }
  .auth-card {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 460px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 30px 80px rgba(16, 34, 55, 0.1);
    border-radius: 28px;
    padding: 3.5rem 2.5rem;
    animation: authCardIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  @keyframes authCardIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .auth-header {
    text-align: center;
    margin-bottom: 2.5rem;
  }
  .auth-header h2 {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, var(--text) 0%, var(--accent-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .auth-header p {
    color: var(--muted);
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.5;
  }
  .auth-field {
    margin-bottom: 1.5rem;
    position: relative;
  }
  .auth-field label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text);
  }
  .auth-input-wrapper input {
    width: 100%;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(16, 34, 55, 0.1);
    border-radius: 16px;
    padding: 1rem 1.2rem;
    font-size: 1rem;
    color: var(--text);
    transition: all 0.3s ease;
  }
  .auth-input-wrapper input:focus {
    outline: none;
    border-color: var(--accent);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(0, 167, 255, 0.12);
  }
  .auth-button {
    width: 100%;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 1.1rem;
    font-weight: 700;
    font-size: 1.05rem;
    cursor: pointer;
    box-shadow: 0 15px 35px rgba(0, 167, 255, 0.2);
    transition: all 0.3s ease;
    margin-top: 1rem;
  }
  .auth-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 40px rgba(0, 167, 255, 0.3);
    filter: brightness(1.05);
  }
  .auth-footer {
    text-align: center;
    margin-top: 2rem;
    font-size: 0.95rem;
    color: var(--muted);
  }
  .auth-footer a {
    color: var(--accent);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
  }
  .auth-footer a:hover {
    color: var(--accent-dark);
  }
</style>

<div class="auth-container">
  <div class="auth-bg-glow"></div>
  
  <div class="auth-card">
    <div class="auth-header">
      <h2>Welcome Back</h2>
      <p>Access your GlobeTrek account to manage bookings, payments, and travel plans.</p>
    </div>

    <form method="post" action="/globetrek/api/login.php">
      <div class="auth-field">
        <label>Email Address</label>
        <div class="auth-input-wrapper">
          <input name="email" type="email" placeholder="name@example.com" required autocomplete="email">
        </div>
      </div>
      
      <div class="auth-field">
        <label>Password</label>
        <div class="auth-input-wrapper">
          <input name="password" type="password" placeholder="••••••••" required autocomplete="current-password">
        </div>
      </div>
      
      <button type="submit" class="auth-button">Sign In</button>
    </form>
    
    <div class="auth-footer">
      Don't have an account? <a href="/globetrek/pages/register.php">Create one now</a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>