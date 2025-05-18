<div style="display: flex; 
    flex-direction: column; 
    gap: 12px;
    border: 1px solid black; 
    padding: .5rem 1rem .2rem 1rem; 
    border-radius: 0.5rem;">
    <strong style="font-size: clamp(1rem, 5vw, 1.5rem);"><?= esc($name) ?></strong>
    <p style="color: gray; justify-self: flex-end; margin: 0;">Senast uppdaterad:
        <?= esc(date('Y-m-d', strtotime($date))) ?>
    </p>
</div>