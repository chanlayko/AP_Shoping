<div class="search_input" id="search_input_box">
    <div class="container">
        <form class="d-flex justify-content-between" method="post">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
            <input type="text" class="form-control" id="search_input" name="search" placeholder="Search Here">
            <button type="submit" class="btn"></button>
            <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
        </form>
    </div>
</div>