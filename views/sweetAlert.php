<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

if($resultado){  
    ?>
    <script>
        Swal.fire({
        icon: 'success',
        title: '<?php echo $titulo;?>',
        text: '<?php echo $mensaje;?>',
        button:'OK'
    }).then(()=>{
        setTimeout(()=>{
            <?php if($reload){  
            ?>
                window.location.reload();

            <?php }
            else{
            ;?>
                <?php if($header){
                ?>
                window.location='<?php echo $headerDir;?>';

                <?php };?>

            <?php };?>
                    
        });
    });
    
     </script>   
    <?php } 
    else if (!$resultado and $resultado!=null) {
    
    ;?>
    <script>
        Swal.fire({
        icon: 'error',
        title: '<?php echo $titulo;?>',
        text: '<?php echo $mensaje;?>',
        button:'OK'
    }).then(()=>{
        setTimeout(()=>{
            <?php if($reload){  
            ?>
                window.location.reload();

            <?php };?>
        });
    });
    
     </script> 
    
    
    <?php };?>