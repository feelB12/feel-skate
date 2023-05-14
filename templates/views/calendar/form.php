<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">Titre</label>
            <input id="name" type="text" required class="form-control" name="name" value="<?= isset($data['name']) ? h($data['name']) : ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <small class="form-text text-muted"><?= $errors['name']; ?></small>
            <?php endif ; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date">Date</label>
            <input id="date" type="date" required class="form-control" name="date" value="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
            <?php if (isset($errors['date'])): ?>
                <small class="form-text text-muted"><?= $errors['date']; ?></small>
            <?php endif ; ?>
        </div>
    </div>
</div>
<div class="row">  
    <div class="col-sm-6">
        <div class="form-group">
        <label for="start">Début</label>
            <input id="start" type="time" class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
            <?php if (isset($errors['start'])): ?>
                <small class="form-text text-muted"><?= $errors['start']; ?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="end">Fin</label>
            <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
            <?php if (isset($errors['end'])): ?>
                <small class="form-text text-muted"><?= $errors['end']; ?></small>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control edit-description"><?= isset($data['description']) ? h($data['description']) : ''; ?></textarea>
</div>
<div class="form-group">

     <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                         
        <input type="radio" name="status" id="status1" autocomplete="off" class="form-control btn-check" value="<?= isset($data['status']) ? h($data['status']) : ''; ?>">
        <?php if (isset($errors['status'])): ?>
                <small class="form-text text-muted"><?= $errors['status']; ?></small>
            <?php endif; ?>
        <label class="btn btn-outline-primary" for="status1" >publier un évènement</label>

        <input type="radio" name="status" id="status2" autocomplete="off" class="form-control btn-check" value="<?= isset($data['status']) ? h($data['status']) : ''; ?>">
        <?php if (isset($errors['hide'])): ?>
                <small class="form-text text-muted"><?= $errors['hide']; ?></small>
            <?php endif; ?>
        <label class="btn btn-outline-primary" for="status2">cacher un évènement</label>
        

    </div>
</div>
<div class="row">  
<div class="col-sm-6 ">
        <div class="form-group">
            <label for="date">Date de création : <?= isset($data['date']) ? h($data['date']) : ''; ?></label>
            
        </div>
    </div>
</div>
