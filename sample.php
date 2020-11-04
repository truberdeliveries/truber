
<?php include 'includes/scripts.php'; ?>
<br/><br/>
<div id="maps">
    <form method="post" action="javascript:void(0)">
        <div class="inputContainer">
            <i class="fa fa-street-view fa-2x icon"> </i>
            <input class="form-control Field" type="text" placeholder="Pick-Up Address" autofocus="" name="start" onkeydown="getMap()" required>
            <br/>
            <table class="all-info" style="position: absolute;background: white;"></table>

        </div>
        <br/>
        <div class="inputContainer">
            <i class="fa fa-map-marker fa-2x icon"> </i>
            <input class="form-control Field" type="text" placeholder="Destination Address" name="destination" required >
        </div>
        <button type="submit" onclick="$('.all-info').click();" class="setAdress">Request</button>
    </form>

    <br/><br/><br/>

    <iframe width="450" height="300" frameborder="0" style="border:5px"></iframe>
</div>

<script type="text/javascript">


</script>

<!--<iframe src="https://maps.google.com/maps?q=-25.754130, 28.195780&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>-->