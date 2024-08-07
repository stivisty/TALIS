<?php
// ---------------------------------------------------------------------------------------
// fonction de REDIMENSIONNEMENT physique "CROP CENTRE" et Enregistrement
// ---------------------------------------------------------------------------------------
// retourne : true si le redimensionnement et l enregistrement ont bien eu lieu, sinon false
// ---------------------------------------------------------------------------------------
// La FONCTION : fctcropimage ($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
// Les parametres :
// - $W_fin : LARGEUR finale --> ou 0
// - $H_fin : HAUTEUR finale --> ou 0
// - $rep_Dst : repertoire de l image de Destination (d�prot�g�) --> ou ''
// - $img_Dst : NOM de l image de Destination --> ou ''
// - $rep_Src : repertoire de l image Source (d�prot�g�)
// - $img_Src : NOM de l image Source
// ---------------------------------------------------------------------------------------
// 4 options :
// A- si $W_fin != 0 et $H_fin != 0 : crop aux dimensions indiquees
// B- si $W_fin == 0 et $H_fin != 0 : crop en HAUTEUR (meme largeur que la source)
// C- si $W_fin != 0 et $H_fin == 0 : crop en LARGEUR (meme hauteur que la source)
// D- si $W_fin == 0 et $H_fin == 0 : (special) crop "carre" a la plus petite dimension de l image source
// ---------------------------------------------------------------------------------------
// $rep_Dst : il faut s'assurer que les droits en �criture ont �t� donn�s au dossier (chmod)
// - si $rep_Dst = '' --> $rep_Dst = $rep_Src (meme repertoire que le repertoire Source)
// - si $img_Dst = '' --> $img_Dst = $img_Src (meme nom que l image Source)
// - si $rep_Dst = '' ET $img_Dst = '' --> on ecrase (remplace) l image source ($img_Src) !
// ---------------------------------------------------------------------------------------
// NB : $img_Dst et $img_Src doivent avoir la meme extension (meme type mime) !
// Extensions acceptees (traitees ici) : .jpg , .jpeg , .png
// Pour ajouter d autres extensions : voir la bibliotheque GD ou ImageMagick
// (GD) NE fonctionne PAS avec les GIF ANIMES ou a fond transparent !
// ---------------------------------------------------------------------------------------
// UTILISATION (exemple) :
// $cropOK = fctcropimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
// if ($cropOK == true) { echo 'Crop centr� OK !';  }
// ---------------------------------------------------------------------------------------
function fctcropimage($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
 // ----------------------------------------------------
 $condition = 0;
 // Si certains parametres ont pour valeur '' :
   if ($rep_Dst == '') { $rep_Dst = $rep_Src; } // (meme repertoire)
   if ($img_Dst == '') { $img_Dst = $img_Src; } // (meme nom)
 // ----------------------------------------------------
 // si le fichier existe dans le r�pertoire, on continue...
 if (file_exists($rep_Src.$img_Src)) { 
   // --------------------------------------------------
   // extensions acceptees : 
   $ExtfichierOK = '" jpg jpeg png"'; // (l espace avant jpg est important)
   // extension fichier Source
   $tabimage = explode('.',$img_Src);
   $extension = $tabimage[sizeof($tabimage)-1]; // dernier element
   $extension = strtolower($extension); // on met en minuscule
   // --------------------------------------------------
   // extension OK ? on continue ...
   if (strpos($ExtfichierOK,$extension) != '') {
      // -----------------------------------------------
      // recuperation des dimensions de l image Source
      $img_size = getimagesize($rep_Src.$img_Src);
      $W_Src = $img_size[0]; // largeur
      $H_Src = $img_size[1]; // hauteur
      // -----------------------------------------------
      // condition de crop et dimensions de l image finale
      // -----------------------------------------------
      // A- crop aux dimensions indiquees
      if ($W_fin != 0 && $H_fin != 0) {
         $W = $W_fin;
         $H = $H_fin;
      }      // -----------------------------------------------
      // B- crop en HAUTEUR (meme largeur que la source)
      if ($W_fin == 0 && $H_fin != 0) {
         $H = $H_fin;
         $W = $W_Src;
      }
      // -----------------------------------------------
      // C- crop en LARGEUR (meme hauteur que la source)
      if ($W_fin != 0 && $H_fin == 0) {
         $W = $W_fin;
         $H = $H_Src;         
      }
      // D- crop "carre" a la plus petite dimension de l image source
      if ($W_fin == 0 && $H_fin == 0) {
        if ($W_Src >= $H_Src) {
         $W = $H_Src;
         $H = $H_Src;
        } else {
         $W = $W_Src;
         $H = $W_Src;
        }   
      }
      // -----------------------------------------------
      // creation de la ressource-image "Src" en fonction de l extension
      switch($extension) {
      case 'jpg':
      case 'jpeg':
         $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
         break;
      case 'png':
         $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
         break;
      }
      // --------------------------------------------
      // creation d une ressource-image "Dst" aux dimensions finales
      // fond noir (par defaut)
      switch($extension) {
      case 'jpg':
      case 'jpeg':
         $Ress_Dst = imagecreatetruecolor($W,$H);
         // fond blanc
         $blanc = imagecolorallocate ($Ress_Dst, 255, 255, 255);
         imagefill ($Ress_Dst, 0, 0, $blanc);
         break;
      case 'png':
         $Ress_Dst = imagecreatetruecolor($W,$H);
         // fond transparent (pour les png avec transparence)
         imagesavealpha($Ress_Dst, true);
         $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
         imagefill($Ress_Dst, 0, 0, $trans_color);
         break;
      }
      // -----------------------------------------------
      // CENTRAGE du crop
      // coordonnees du point d origine Scr : $X_Src, $Y_Src
      // coordonnees du point d origine Dst : $X_Dst, $Y_Dst
      // dimensions de la portion copiee : $W_copy, $H_copy
      // -----------------------------------------------
      // CENTRAGE en largeur
      if ($W_fin == 0) {
         if ($H_fin == 0 && $W_Src < $H_Src) {
            $X_Src = 0;
            $X_Dst = 0;
            $W_copy = $W_Src;
         } else {
            $X_Src = 0;
            $X_Dst = ($W - $W_Src) /2;
            $W_copy = $W_Src;
         }
      } else {
         if ($W_Src > $W) {
            $X_Src = ($W_Src - $W) /2;
            $X_Dst = 0;
            $W_copy = $W;
         } else {
            $X_Src = 0;
            $X_Dst = ($W - $W_Src) /2;
            $W_copy = $W_Src;
         }
      }
      // -----------------------------------------------
      // CENTRAGE en hauteur
      if ($H_fin == 0) {
         if ($W_fin == 0 && $H_Src < $W_Src) {
            $Y_Src = 0;
            $Y_Dst = 0;
            $H_copy = $H_Src;
         } else {
            $Y_Src = 0;
            $Y_Dst = ($H - $H_Src) /2;
            $H_copy = $H_Src;
         }
      } else {
         if ($H_Src > $H) {
            $Y_Src = ($H_Src - $H) /2;
            $Y_Dst = 0;
            $H_copy = $H;
         } else {
            $Y_Src = 0;
            $Y_Dst = ($H - $H_Src) /2;
            $H_copy = $H_Src;
         }
      }
      // -----------------------------------------------
      // CROP par copie de la portion d image selectionnee
 imagecopyresampled($Ress_Dst,$Ress_Src,$X_Dst,$Y_Dst,$X_Src,$Y_Src,$W_copy,$H_copy,$W_copy,$H_copy);
      // --------------------------------------------
      // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
      switch ($extension) { 
      case 'jpg':
      case 'jpeg':
         imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
         break;
      case 'png':
         imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
         break;
      }
      // --------------------------------------------
      // liberation des ressources-image
      imagedestroy ($Ress_Src);
      imagedestroy ($Ress_Dst);
      // --------------------------------------------
      $condition = 1;
   }
 }
// ---------------------------------------------------------------------------------------
 // si le fichier a bien ete cree
 if ($condition == 1 && file_exists($rep_Dst.$img_Dst)) { return true; }
 else { return false; }
}
// retourne : true si le redimensionnement et l enregistrement ont bien eu lieu, sinon false
// ---------------------------------------------------------------------------------------
?>