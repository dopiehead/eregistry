<div class='brands mt-5'>
   <?php 
     for ($i = 0; $i < 10; $i++): ?>
         <div style="width:150px;" class="text-center shadow p-1 me-2 mb-1">
            <img style="height:150px;width:100%;" src="https://placehold.co/400" alt="brands">
            <h6 class="text-secondary fw-bold mt-2">Brands</h6>
         </div>
    <?php endfor; ?>
</div>

<script> 
  $('.brands').flickity({
 cellAlign: 'left',
contain: true,
autoPlay:true,
freeScroll: true,
 friction:0.52,
wrapAround: true,
contain: true,
prevNextButtons: true,

});

</script>