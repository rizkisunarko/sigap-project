<div class="terms-row">
    <input type="checkbox" id="terms" name="terms" <?= isset($old['terms']) ? 'checked' : ''; ?> required>
    <label for="terms" class="terms-text">
        Saya menyatakan bahwa data yang saya isi adalah benar dan saya menyetujui Syarat & Ketentuan serta Kebijakan<br>Privasi yang berlaku di Rumah Sakit ini.
    </label>
    
    <?php if (isset($errors['terms'])): ?>
        <div style="color: #cc0000; font-size: 9px; margin-top: 5px; line-height: 1.2; width: 100%;">
            <?= $errors['terms']; ?>
        </div>
    <?php endif; ?>
</div>