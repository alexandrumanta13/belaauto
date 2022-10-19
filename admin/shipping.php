<?php
require("../../config/settings.php");
require("blocks/header.php");

if(isset($_POST['delete'])){
    $couriers = new Shipping;
    $couriers->delete($_POST['shipping_id']);
    
    $_SESSION['succes'] = "The courier \"{$_POST['courierName']}\" was deleted!";
}

if (isset($_POST['new_shipping'])){
    $courier = new Shipping($_POST['new_shipping']);
    if($_POST['new_shipping'] == 'true') {
        $data = array(
            "courier" => array(
                "required" => "Courier name is required!"
            )

        );
    }elseif($_POST['courier'] == $courier->courier){
        $data = array(
            "courier" => array("required" => "Courier name is required!")
        );
    }else{
        $data = array(
            "courier" => array(
                "required" => "Courier name is required!"
            )

        );
    }
    try{
        $errors = Functions::Validate($data, $_POST);
        if (!$errors){

            $courier = new Shipping;
            $courier->courier = $_POST['courier'];
            $courier->method = $_POST['method'];
            $courier->price = $_POST['price'];

            if ($_POST['new_shipping'] == 'true'){
                if ($courier->save()){

                    $_SESSION['succes'] = "Courier '{$courier->courier}' was saved!";
                    $url = "shipping.php";
                    echo "<META HTTP-EQUIV=\"refresh\" content=\"0; URL=".$url."\"> ";
                    exit();
                }else{
                    $errors[] = "The courier was not saved!";
                }
            }elseif (is_numeric($_POST['new_shipping'])){
                $courier->id = $_POST['new_shipping'];
                

                if ($courier->save()){
                    $_SESSION['succes'] = "Courier '{$courier->courier}' was modified!";

                }
            }
        }
    }
    catch (Exception $e){
        $errors[] = $e->getMessage();
    }
}

?>
<div class="main-content">
    <nav class="navbar user-info-navbar" role="navigation">
        <ul class="user-info-menu left-links list-inline list-unstyled">
            <?php require("blocks/notifications.php"); ?>
        </ul>
        <?php require("blocks/user-settings.php"); ?>
    </nav>
    <div class="page-title">
        <div class="title-env">
            <?php 

            if(isset($_GET['add'])) :
                $title = "Adauga curier";           
                $description = "Adauga, editeaza sau sterge curieri";
            elseif(isset($_GET['edit'])) :
                $courier = new Shipping($_GET['edit']);
                $title = "Editeaza curier";
                $description = $courier->courier;
            else :
                $title = "Curieri";
                $description = "Adauga, editeaza sau sterge curieri";
                endif;?>

                <h1 class="title"><?= $title ?></h1>
                <p class="description"><?= $description ?></p>
            </div> 
        </div>
        <div class="panel panel-default">

            <div class="panel-heading"><?= $title ?></div>

            <?php if((isset($_GET['edit'])) or (isset($_GET['add']))) : ?>

            <?php else :?>
                <p style="margin-top: 15px">
                    <a class="btn btn-primary btn-sm" href="shipping.php?action=courier&add=true"><i class="fa fa-plus" style="padding-right: 15px"></i>Adauga curier</a>
                </p>
            <?php endif; ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if ((isset($errors)) and (is_array($errors))) : ?>
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <?php foreach ($errors as $error) :
                                echo $error;
                                endforeach; ?>
                            </div>
                        <?php endif; 
                        if ((isset($_GET['add'])) or (isset($_GET['edit']))) :
                            if (isset($_GET['edit'])) :
                                $edit = new Shipping($_GET['edit']);
                            endif;

                            ?>

                            <form class="validate" action="<?php echo $_SERVER['PHP_SELF'];?>?action=courier" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Firma curierat</label>
                                        <input type="text" class="form-control" name="courier" id="courier" value="<?php echo (isset($edit)) ? $edit->courier : '';?>" data-validate="required" data-message-required="Courier name is required" />
                                    </div>
 
                                    <div class="form-group col-xs-4">
                                        <label class="control-label">Pret</label>
                                        <input type="text" class="form-control" name="price" id="price" value="<?php echo (isset($edit)) ? $edit->price : '';?>" data-validate="required" data-message-required="Price is required" />
                                    </div>
                                </div>
                                <input type="hidden" name="new_shipping" value="<?php echo (isset($edit)) ? $edit->id : 'true';?>" />
                                <button class="btn btn-info" type="submit" value="Save">
                                    <i style="top: 3px; padding-right: 10px;" class="glyphicon glyphicon-save"></i>Save
                                </button>
                            </form>
                        <?php else : 
                        if (isset($_SESSION['succes'])) : ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <?= $_SESSION['succes']; ?>
                        </div>
                        <?php unset($_SESSION['succes']);
                    endif ;
                    $courier = new Shipping();                  
                    $couriers = $courier->getCouriers();
                    if (count($couriers) > 0) :
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Curieri</th>

                                    <th>Optiuni</th>
                                </tr>
                            </thead>
                            <?php
                            $cnt = 0;
                            $couriers = Shipping::Paginate();
                            foreach ($couriers as $courier) : 
                                $cnt++;  
                                ?>  
                                <tr>
                                    <td><?= $cnt; ?></td>
                                    <td><?= $courier->courier; ?></td>

                                    
                                    <td>
                                        <a style="float: left; margin-right: 10px;" class="btn btn-icon btn-warning" href="shipping.php?action=courier&edit=<?= $courier->id ?>">
                                            <i class="fa-wrench"></i>
                                        </a>
                                        
                                        <a style="float: left; margin-right: 10px;" class="btn btn-icon btn-red" onclick="jQuery('#deleteModal_<?=$courier->id?>').modal('show', {backdrop: 'true'});">
                                            <i class="fa-remove"></i>
                                        </a>
                                        <div id="deleteModal_<?=$courier->id?>" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Delete</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Really delete <?= $courier->courier; ?>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="delete" method="post" action="">
                                                            <input type="hidden" name="shipping_id" value="<?= $courier->id; ?>"/> 
                                                            <input type="hidden" name="courierName" value="<?= $courier->courier; ?>"/> 
                                                            <input type="hidden" name="delete" value="true"/>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button id="remove" type="submit" value="Delete" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?= Shipping::Links(); 
                        else : ?>
                        <div class="error">Niciun curier introdus!</div>
                    <?php endif;
                    endif ?>
                </div>
            </div>                    
        </div> 
    </div> 
    <?php
    require("blocks/footer.php");
    ?>
</div> 
</div>



