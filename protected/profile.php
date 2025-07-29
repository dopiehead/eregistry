<?php include("contents/permission.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/profile.css">
</head>
<body>
<!-- Sidebar -->
<?php @include("components/sidebar.php") ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Bar -->
    <?php @include("components/topbar.php") ?>

    <div class='mt-3 px-3'>
        <a class='btn border border-1 border-mute text-secondary btn-edit'><span class='fa fa-edit'></span>Edit</a>
    </div>

    <div class='d-flex justify-content-between shadow-lg px-3 py-4 mt-4 bg-white border border-1 border-mute'>
        <div class='d-flex flex-column-start gap-2'>
            <div class='d-flex flex-column flex-row'>
                <?php
                $headings = [
                    ['tag' => 'h6', 'class' => 'fw-bold text-secondary text-capitalize', 'text' => $name ?? ''],
                    ['tag' => 'small', 'class' => 'text-secondary text-capitalize', 'text' => $email ?? ''],
                    ['tag' => 'small', 'class' => 'text-secondary text-capitalize', 'text' => $location ?? ''],
                    ['tag' => 'small', 'class' => 'text-primary text-capitalize', 'text' => $occupation ?? ''],
                ];
                foreach ($headings as $item) {
                    echo "<{$item['tag']} class='{$item['class']}'>" . htmlspecialchars($item['text']) . "</{$item['tag']}>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class='px-3 py-2 border border-1 border-mute shadow-lg bg-white mt-4'>
        <div class='d-flex justify-content-between'>
            <h5 class='fw-bold'>Personal information</h5>
        </div>

        <div class='d-flex justify-content-start text-secondary flex-md-row flex-column px-3 gap-5'>
            <?php
            $fields = [
                ['label' => 'Name', 'field' => 'name', 'value' => $name ?? '', 'editable' => true],
                ['label' => 'Password', 'field' => 'password', 'value' => substr(str_repeat('*', strlen($password ?? '')), 0, 14), 'editable' => true, 'id' => 'password']
            ];
            foreach ($fields as $item): ?>
                <div class='d-flex flex-row flex-column text-secondary mt-3'>
                    <label for="<?= $item['field'] ?>"><?= $item['label'] ?></label>
                    <span <?= isset($item['id']) ? "id='{$item['id']}'" : '' ?> class='fw-bold text-capitalize' onmouseover="changeBackground(this)" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', '<?= $item['field'] ?>')" contenteditable='<?= $item['editable'] ? 'true' : 'false' ?>'>
                        <?= htmlspecialchars($item['value']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class='d-flex justify-content-between flex-md-row flex-column px-3'>
            <?php
            $infoFields = [
                ['label' => 'Email address', 'field' => 'email', 'value' => $email ?? '', 'editable' => false, 'tag' => 'strong', 'class' => 'fw-bold text-success'],
                ['label' => 'Phone number', 'field' => 'phone', 'value' => $phone ?? '', 'editable' => true, 'tag' => 'span', 'class' => 'fw-bold'],
                ['label' => 'Date of Birth(Y-m-d)', 'field' => 'dob', 'value' => $dob ?? '', 'editable' => true, 'tag' => 'span', 'class' => 'fw-bold']
            ];
            foreach ($infoFields as $item): ?>
                <div class='d-flex flex-column text-secondary mt-3'>
                    <label><?= $item['label'] ?></label>

                    <?php if ($item['field'] === 'dob'): ?>
                        <input 
                          type="date"
                          class="form-control <?= $item['class'] ?>"
                          value="<?= htmlspecialchars($item['value']) ?>"
                          onchange="saveData(this, '<?= htmlspecialchars($id) ?>', '<?= $item['field'] ?>')"
                        />
                    <?php else: ?>
                        <<?= $item['tag'] ?>
                            class="<?= $item['class'] ?>"
                            <?= $item['editable'] ? "onmouseover=\"changeBackground(this)\" onfocus=\"changeBackground(this)\" contenteditable='true' onblur=\"saveData(this, '" . htmlspecialchars($id) . "', '{$item['field']}')\"" : '' ?>
                        >
                            <?= htmlspecialchars($item['value']) ?>
                        </<?= $item['tag'] ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class='bg-white px-3 py-3 mt-4 shadow-lg'>
            <div class='d-flex justify-content-between'>
                <h5 class='fw-bold'>Address</h5>
            </div>

            <div class='text-secondary d-flex flex-md-row flex-column flex-wrap justify-content-between mt-3'>
                <?php
                $addressFields = [
                    ['label' => 'Country', 'field' => null, 'value' => 'Nigeria', 'editable' => false],
                    ['label' => 'State', 'field' => 'state', 'value' => $state ?? '', 'editable' => true],
                    ['label' => 'LGA', 'field' => 'lga', 'value' => $lga ?? '', 'editable' => true],
                    ['label' => 'Full address', 'field' => 'address', 'value' => $address ?? '', 'editable' => true]
                ];
                foreach ($addressFields as $item): ?>
                    <div class='d-flex flex-row flex-column'>
                        <label for=""><?= $item['label'] ?></label>
                        <span class='fw-bold text-capitalize' <?= $item['editable'] ? "onmouseover=\"changeBackground(this)\" onfocus=\"changeBackground(this)\" contenteditable='true' onblur=\"saveData(this, '" . htmlspecialchars($id) . "', '{$item['field']}')\"" : '' ?>>
                            <?= htmlspecialchars($item['value']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class='bg-white shadow py-2 ps-3 mt-3'>
            <div class='d-flex justify-content-between'>
                <h5 class='fw-bold'>About</h5>
            </div>
            <div class='d-flex flex-row flex-column mt-3 text-secondary'>
                <label for="">Bio</label>
                <span class='fw-bold' onmouseover="changeBackground(this)" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id);?>','user_bio');">
                    <?= htmlspecialchars($bio); ?>
                </span>
            </div>
        </div>
    </div>
</div>
<script src='../assets/js/profile.js'></script>
</body>
</html>
