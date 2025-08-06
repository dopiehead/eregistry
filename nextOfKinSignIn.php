<!DOCTYPE html>
<html lang="en">
<head>
    <?php @include("components/links.php") ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Next of Kin Sign in</title>
    <style>
        /* Keep page white */
        body { background:#fff; }

        /* Remove number spinners across browsers */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }

        /* PIN input look */
        .pin-input {
            width: 64px;
            height: 56px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px;
        }

        /* Responsive bumps for larger screens */
        @media (min-width: 576px) {
            .pin-input { width: 72px; height: 60px; font-size: 1.75rem; }
        }
        @media (min-width: 992px) {
            .pin-input { width: 84px; height: 64px; font-size: 2rem; }
        }

        .full-height {
            min-height: calc(100dvh - 80px); /* account for top nav spacing */
        }

        .form-card {
            width: 100%;
            max-width: 520px;
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <!-- Top nav row -->
    <div class="container px-3 py-3 mb-2 d-flex justify-content-between align-items-center">
        <a class="text-primary text-decoration-none" role="button" onclick="history.back()">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
        <a class="text-secondary text-decoration-none" href="index.php">
            Home <i class="fa fa-arrow-right ms-1"></i>
        </a>
    </div>

    <!-- Main -->
    <div class="container d-flex justify-content-center align-items-center full-height">
        <div class="form-card p-4 p-sm-5 border border-2">
            <div class="text-center mb-3">
                <h1 class="fw-bold m-0">PIN</h1>
                <p class="text-secondary mt-2 mb-0">Enter your 4-digit PIN</p>
            </div>

            <form id="pinForm" autocomplete="one-time-code" class="mt-4">
                <div class="d-flex justify-content-center gap-2 gap-sm-3">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <input
                            type="number"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            aria-label="PIN digit <?= $i ?>"
                            class="pin-input form-control border border-2"
                            name="pin[]"
                            id="pin-<?= $i ?>"
                            maxlength="1"
                            min="0" max="9"
                        />
                    <?php endfor; ?>
                </div>

                <div class="mt-3 text-danger text-center" id="error-message" role="alert" aria-live="polite"></div>

                <div class="d-grid mt-3">
                    <button name="submit" type="submit" class="btn btn-primary py-2 fw-semibold">Continue</button>
                </div>
            </form>

            <!-- <div class="text-center mt-3">
                <small class="text-muted">Having trouble? <a href="#" class="text-decoration-none">Reset PIN</a></small>
            </div> -->
        </div>
    </div>

    <?php @include 'components/footer.php' ?>

    <script src="assets/js/nextOfKinSignIn.js"></script>
</body>
</html>
