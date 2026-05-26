<div class="section-title">AKUN PENGGUNA</div>
<div class="section-divider"></div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Username :</label></div>
    <div class="input-col">
        <input type="text" class="custom-input" name="username" 
               value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : ''; ?>"
               required>
        
        <?php if (isset($errors['username'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['username']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="form-row">
    <div class="label-col"><label class="custom-label">Password :</label></div>
    <div class="input-col">
        <input type="password" class="custom-input" name="password" required>
        
        <?php if (isset($errors['password'])): ?>
            <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2;">
                <?= $errors['password']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>