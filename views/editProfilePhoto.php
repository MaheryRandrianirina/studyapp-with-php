<i class="fas fa-window-close close"></i>
<form action="<?=$router->generate('profilePhotoAction')?>" enctype="multipart/form-data" method="post" class="editProfilePhotoForm">
    <label for="addProfilePhoto">Ajoutez votre nouvelle photo de profil :</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <i class="fas fa-camera pick-profile-photo"></i>
    <button type="submit" class="editProfilePhotoBtn">Ajouter</button>
</form>