<div style="display: flex; 
    flex-direction: column;
    background-color: white; 
    gap: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: .5rem 1rem .2rem 1rem; 
    border-radius: 0.5rem;">
    <strong style="font-size: clamp(1rem, 5vw, 1.5rem);"><?= esc($name) ?></strong>
    <p style="color: gray; justify-self: flex-end; margin: 0;">Senast uppdaterad:
        <?= esc(date('Y-m-d', strtotime($date))) ?>
    </p>
</div>