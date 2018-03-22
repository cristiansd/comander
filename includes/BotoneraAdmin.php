
       <div class="w3-margin-left w3-padding-bottom w3-padding-top">
      <p><?php echo $localTag.$_SESSION['nombre_establecimiento'];?></p>
      <p><?php echo $userMinusTag. $_SESSION['MM_Username'];?></p>
    </div>
    <ul class="w3-ul w3-blue-grey w3-hoverable w3-padding-top">
      <li onclick="window.location.href='administracionCategoriaAdmin.php';"><?php echo $categoriesTag; ?></li>
      <li onclick="window.location.href='administracionSubcategoriasAdmin.php';"><?php echo $subcategoriesTag; ?></li>
      <li onclick="window.location.href='administracionProductosAdmin.php';"><?php echo $productsTag; ?></li>
      <li onclick="window.location.href='administracionOfertasAdmin.php';"><?php echo $offersTag; ?></li>
      <li onclick="window.location.href='administracionMenusAdmin.php';"><?php echo $menusTag; ?></li>
      <li onclick="window.location.href='administracionMesasAdmin.php';"><?php echo $tablesTag; ?></li>
      <li onclick="window.location.href='administracionUsuariosAdmin.php';"><?php echo $usersTag; ?></li>
      <li onclick="window.location.href='administracionZonasAdmin.php';"><?php echo $areasTag; ?></li>
      <li onclick="window.location.href='administracionVentasAdmin.php';"><?php echo $customerServiceTag; ?></li>
      <li onclick="window.location.href='administracionContabilidadAdmin.php';"><?php echo $factursAdminTag; ?></li>
      <li onclick="window.location.href='administracionLocalAdmin.php';"><?php echo $localAdminTag; ?></li>
      <li onclick="window.location.href='cerrarSesionAdmin.php';"><?php echo $exitTag; ?></li>
      <li onclick="window.location.href='';"><?php echo $helpTag; ?></li>
    </ul>
     
