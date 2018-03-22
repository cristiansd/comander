<?php
function cabeceraNavegacionUsuario($texto){ ?>
<header class="w3-container w3-card-4 w3-theme header">
            <h3 style="margin-top: 14px;">
                 <i class="material-icons w3-xlarge w3-margin-right" onclick="window.history.back();">&#xE5C4;</i>
                <span class="w3-margin-left"><?php echo $texto; ?></span>
                <i class="material-icons w3-xlarge w3-right w3-margin-left " onclick="window.location.href='productosBuscarUsuario.php';">search</i>                
                <i class="material-icons w3-xlarge w3-right w3-margin-left w3-margin-right" onclick="">person</i>
                <i class="material-icons w3-xlarge w3-right w3-margin-right " onclick="window.location.href='principalUsuario.php';">home</i>
            </h3>
</header>
<?php } ?>