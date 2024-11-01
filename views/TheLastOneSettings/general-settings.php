<div class="addon-header">
    <h2>The Last One</h2>
</div>
<div class="addon-container">
<form method="post" action="options.php">
<?php settings_fields(self::$settingsGroup); ?>
<ul class="addons">
<?php $count=0;foreach($addons as $addon){ ?>
<li class="col s12 m3 addon-item">
   <?php
        $field=array('type' => 'checkbox', 'default' => $settings['addon_id_'.$addon['Id']]);
    ?>
    <div class="switch"> 
          <?php echo self::getInputField(self::$defaultSettings,'addon_id_'.$addon['Id'],$field,false); ?>
    </div>
    <span class="title"><?php echo $addon['Name']?></span>
    <span class="desc"><?php echo $addon['Description']?></span>
    <div class="addon__author-details">
        <span class="version"><span style="color:#000;">Version:</span> <?php echo $addon['Version']?></span>
        <span class="author">Author: <a class="author_uri" href="<?php echo $addon['AuthorURI']?>" target="_blank"><?php echo $addon['Author']?></a></span>
    </div>
    
</li>

<?php $count++;}?>
</ul>    
<?php submit_button(null, 'primary', null, false); ?>

</form>
</div>
<script>
jQuery(document).ready(function($){
    equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).load(function() {
  equalheight('.addon-container .addon-item');
});


$(window).resize(function(){
  equalheight('.addon-container .addon-item');
});
});
</script>