<div class="hero-section d-flex flex-column justify-content-center align-items-center text-center px-3 px-md-5 gap-3">
  <h2 class="text-white fw-bold display-5">E-Registry</h2>
  <p class="text-white fs-5 mb-3">Find people and information about them</p>

  <div class="search-box d-flex flex-column flex-md-row align-items-stretch align-items-md-center w-100 w-md-75 w-lg-50 shadow bg-white rounded-pill px-3 py-2">
    <input type="text" id="q" class="form-control border-0 flex-grow-1 me-0 me-md-2 mb-2 mb-md-0 shadow-none" placeholder="Enter name or details">
    <a href="#" class="btn btn-danger rounded-pill py-2 w-100 w-md-auto">Search</a>
  </div>
  <div class='search_result'></div>
</div>

<script>

let debounceTimer;
$(document).on("keyup", "#q", function (e) {
    e.preventDefault();
    clearTimeout(debounceTimer);
    const x = $(this).val().trim();

    debounceTimer = setTimeout(() => {
        if (x.length > 0) {
            $.ajax({
                type: "GET",
                url: "engine/user-info",
                data: { q: x },
                success: function (data) {
                    $(".search_result").html(data).show();
                },
                error: function(xhr, status, error) {
                  console.error("Search error:", status, error);
                  $(".search_result").html("<p>Error fetching results</p>").show();
                }
            });
        } else {
            $(".search_result").html("").hide();
        }
    }, 300); // Wait 300ms after user stops typing
});
</script>
