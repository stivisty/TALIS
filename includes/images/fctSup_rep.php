<?php

function rmdir_recursive($dir)
{
	//Liste le contenu du r�pertoire dans un tableau
	$dir_content = scandir($dir);
	//Est-ce bien un r�pertoire?
	if($dir_content !== FALSE){
		//Pour chaque entr�e du r�pertoire
		foreach ($dir_content as $entry)
		{
			//Raccourcis symboliques sous Unix, on passe
			if(!in_array($entry, array('.','..'))){
				//On retrouve le chemin par rapport au d�but
				$entry = $dir . '/' . $entry;
				//Cette entr�e n'est pas un dossier: on l'efface
				if(!is_dir($entry)){
					unlink($entry);
				}
				//Cette entr�e est un dossier, on recommence sur ce dossier
				else{
					rmdir_recursive($entry);
				}
			}
		}
	}
	//On a bien effac� toutes les entr�es du dossier, on peut � pr�sent l'effacer
	rmdir($dir);
}

?>