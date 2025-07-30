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

    
    <div class='px-3 py-2 border border-1 border-mute shadow-lg bg-white mt-4'>
        <div class='d-flex justify-content-between'>
            <h5 class='fw-bold'>Personal information</h5>
        </div>

        <div class='d-flex justify-content-start text-secondary flex-md-row flex-column px-3 gap-5'>

            <div class='d-flex flex-row flex-column text-secondary mt-3'>
                <label for="name">Name</label>
                <input id="name" type="text" class='form-control fw-bold text-capitalize' value="<?= htmlspecialchars($name ?? '') ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'name')" />
            </div>

            <div class='d-flex flex-row flex-column text-secondary mt-3'>
                <label for="password">Password</label>
                <input id="password" type="password" class='form-control fw-bold text-capitalize' value="<?= htmlspecialchars($password ?? '') ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'password')" />
            </div>

        </div>

        <div class='d-flex justify-content-between flex-md-row flex-column px-3'>
            <?php
            $infoFields = [
                ['label' => 'Email address', 'field' => 'email', 'value' => $email ?? '', 'editable' => true],
                ['label' => 'Phone number', 'field' => 'phone', 'value' => $phone ?? '', 'editable' => true],
                ['label' => 'Date of Birth(Y-m-d)', 'field' => 'dob', 'value' => $dob ?? '', 'editable' => true, 'type' => 'date']
            ];
            foreach ($infoFields as $item): ?>
                <div class='d-flex flex-column text-secondary mt-3'>
                    <label><?= $item['label'] ?></label>
                    <input
                        type="<?= $item['type'] ?? 'text' ?>"
                        class="form-control fw-bold <?= $item['field'] === 'email' ? 'text-success' : '' ?>"
                        value="<?= htmlspecialchars($item['value']) ?>"
                        onfocus="changeBackground(this)"
                        onblur="saveData(this, '<?= htmlspecialchars($id) ?>', '<?= $item['field'] ?>')"
                    />
                </div>
            <?php endforeach; ?>
        </div>

        <div class='bg-white px-3 py-3 mt-4 shadow-lg'>
            <div class='d-flex justify-content-between'>
                <h5 class='fw-bold'>Address</h5>
            </div>

            <div class='text-secondary d-flex flex-md-row flex-column flex-wrap justify-content-between mt-3'>

                <div class='d-flex flex-row flex-column'>
                    <label>Country</label>
                    <input type="text" class='form-control fw-bold text-capitalize border-mute' value="Nigeria" disabled />
                </div>

                <div class='d-flex flex-row flex-column'>
                    <label>State</label>
                    <input type="text" class='form-control fw-bold text-capitalize border-mute' value="<?= htmlspecialchars($state ?? '') ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'state')" />
                </div>

                <div class='d-flex flex-row flex-column'>
                    <label>LGA</label>
                    <input type="text" class='form-control fw-bold text-capitalize border-mute' value="<?= htmlspecialchars($lga ?? '') ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'lga')" />
                </div>

                <div class='d-flex flex-row flex-column'>
                    <label>Full address</label>
                    <input type="text" class='form-control fw-bold text-capitalize border-mute' value="<?= htmlspecialchars($address ?? '') ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', 'address')" />
                </div>

            </div>
        </div>

        <div class='bg-white shadow py-2 ps-3 mt-3'>
            <div class='d-flex justify-content-between'>
                <h5 class='fw-bold'>About</h5>
            </div>
            <div class='d-flex flex-row flex-column mt-3 text-secondary'>
                <label>Bio</label>
                <textarea class='form-control fw-bold' onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id); ?>','user_bio');"><?= htmlspecialchars($bio); ?></textarea>
            </div>
        </div>

        <div class='mt-3 py-3 shadow bg-white px-3'>
            <div class='d-flex justify-content-between'>
                <h5 class='fw-bold'>Banking details</h5>
            </div>

            <div class='d-flex justify-content-between flex-md-row flex-column mt-3'>
                <?php
                $bank_fields = [
                    ['label' => 'Bank name', 'field' => 'bank_name', 'value' => $bank_name ?? ''],
                    ['label' => 'Bank account', 'field' => 'bank_account', 'value' => $bank_account ?? ''],
                    ['label' => 'Bank balance', 'field' => 'bank_balance', 'value' => $bank_balance ?? '']
                ];
                foreach ($bank_fields as $bank): ?>
                    <div class='mb-3 me-3'>
                        <label><?= htmlspecialchars($bank['label']) ?></label>
                        <input type="text" class="form-control border-mute" value="<?= htmlspecialchars($bank['value']) ?>" onfocus="changeBackground(this)" onblur="saveData(this, '<?= htmlspecialchars($id) ?>', '<?= $bank['field'] ?>')" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src='../assets/js/profile.js'></script>
</body>
</html>
