<?php

// -----------------------------------------------
// Cryptographp v1.4
// (c) 2006-2007 Sylvain BRISON 
//
// www.cryptographp.com 
// cryptographp@alphpa.com 
//
// Licence CeCILL modifi�e
// => Voir fichier Licence_CeCILL_V2-fr.txt)
// -----------------------------------------------


// -------------------------------------
// Configuration du fond du cryptogramme
// -------------------------------------

$cryptwidth  = sfConfig::get('app_cryptographp_width', 130);  // Largeur du cryptogramme (en pixels)
$cryptheight = sfConfig::get('app_cryptographp_height', 40);    // Hauteur du cryptogramme (en pixels)

$bgR  = sfConfig::get('app_cryptographp_bg_r', 255);          // Couleur du fond au format RGB: Red (0->255)
$bgG  = sfConfig::get('app_cryptographp_bg_g', 255);         // Couleur du fond au format RGB: Green (0->255)
$bgB  = sfConfig::get('app_cryptographp_bg_b', 255);        // Couleur du fond au format RGB: Blue (0->255)

$bgclear = sfConfig::get('app_cryptographp_bg_clear', true);    // Fond transparent (true/false)
                     // Uniquement valable pour le format PNG

$bgimg = sfConfig::get('app_cryptographp_bg_img', '');                // Le fond du cryptogramme peut-�tre une image  
                             // PNG, GIF ou JPG. Indiquer le fichier image
                             // Exemple: $fondimage = 'photo.gif';
				                     // L'image sera redimensionn�e si n�cessaire
                             // pour tenir dans le cryptogramme.
                             // Si vous indiquez un r�pertoire plut�t qu'un 
                             // fichier l'image sera prise au hasard parmi 
                             // celles disponibles dans le r�pertoire

$bgframe = sfConfig::get('app_cryptographp_bg_frame', true);    // Ajoute un cadre de l'image (true/false)


// ----------------------------
// Configuration des caract�res
// ----------------------------

// Couleur de base des caract�res

$charR = sfConfig::get('app_cryptographp_char_r', 0);     // Couleur des caract�res au format RGB: Red (0->255)
$charG = sfConfig::get('app_cryptographp_char_g', 0);     // Couleur des caract�res au format RGB: Green (0->255)
$charB = sfConfig::get('app_cryptographp_char_b', 0);     // Couleur des caract�res au format RGB: Blue (0->255)

$charcolorrnd = sfConfig::get('app_cryptographp_char_colorrnd', true);      // Choix al�atoire de la couleur.
$charcolorrndlevel = sfConfig::get('app_cryptographp_char_colorrndlevel', 2);    // Niveau de clart� des caract�res si choix al�atoire (0->4)
                           // 0: Aucune s�lection
                           // 1: Couleurs tr�s sombres (surtout pour les fonds clairs)
                           // 2: Couleurs sombres
                           // 3: Couleurs claires
                           // 4: Couleurs tr�s claires (surtout pour fonds sombres)

$charclear = sfConfig::get('app_cryptographp_char_clear', 10);   // Intensit� de la transparence des caract�res (0->127)
                  // 0=opaques; 127=invisibles
	                // interessant si vous utilisez une image $bgimg
	                // Uniquement si PHP >=3.2.1

// Polices de caract�res

//$tfont[] = 'Alanden_';       // Les polices seront al�atoirement utilis�es.
//$tfont[] = 'bsurp___';       // Vous devez copier les fichiers correspondants
//$tfont[] = 'ELECHA__.TTF';       // sur le serveur.
//$tfont[] = 'luggerbu.ttf';     // Ajoutez autant de lignes que vous voulez   
//$tfont[] = 'RASCAL__';     
//$tfont[] = 'SCRAWL.TTF';  
//$tfont[] = 'WAVY.ttf';   
$tfont = sfConfig::get('app_cryptographp_fonts', array('SCRAWL.TTF'));


// Caracteres autoris�s
// Attention, certaines polices ne distinguent pas (ou difficilement) les majuscules 
// et les minuscules. Certains caract�res sont faciles � confondre, il est donc
// conseill� de bien choisir les caract�res utilis�s.

$charel = sfConfig::get('app_cryptographp_letters_range', 'ABCDEFGHKLMNPRTWXYZ234569');       // Caract�res autoris�s

$crypteasy = sfConfig::get('app_cryptographp_letters_easyread', true);       // Cr�ation de cryptogrammes "faciles � lire" (true/false)
                         // compos�s alternativement de consonnes et de voyelles.

$charelc = sfConfig::get('app_cryptographp_letters_rangec', 'BCDFGHKLMNPRTVWXZ');   // Consonnes utilis�es si $crypteasy = true
$charelv = sfConfig::get('app_cryptographp_letters_rangev', 'AEIOUY');              // Voyelles utilis�es si $crypteasy = true

$difuplow = sfConfig::get('app_cryptographp_difuplow', false);          // Diff�rencie les Maj/Min lors de la saisie du code (true, false)

$charnbmin = sfConfig::get('app_cryptographp_char_nb_min', 4);         // Nb minimum de caracteres dans le cryptogramme
$charnbmax = sfConfig::get('app_cryptographp_char_nb_max', 4);         // Nb maximum de caracteres dans le cryptogramme

$charspace = sfConfig::get('app_cryptographp_char_space', 20);        // Espace entre les caracteres (en pixels)
$charsizemin = sfConfig::get('app_cryptographp_char_size_min', 14);      // Taille minimum des caract�res
$charsizemax = sfConfig::get('app_cryptographp_char_size_max', 16);      // Taille maximum des caract�res

$charanglemax  = sfConfig::get('app_cryptographp_char_anglemax', 25);     // Angle maximum de rotation des caracteres (0-360)
$charup   = sfConfig::get('app_cryptographp_char_up', true);      // D�placement vertical al�atoire des caract�res (true/false)

// Effets suppl�mentaires

$cryptgaussianblur = sfConfig::get('app_cryptographp_effects_gaussianblur', false); // Transforme l'image finale en brouillant: m�thode Gauss (true/false)
                            // uniquement si PHP >= 5.0.0
$cryptgrayscal = sfConfig::get('app_cryptographp_effects_grayscal', false);     // Transforme l'image finale en d�grad� de gris (true/false)
                            // uniquement si PHP >= 5.0.0

// ----------------------
// Configuration du bruit
// ----------------------

$noisepxmin = sfConfig::get('app_cryptographp_noise_px_min', 10);       // Bruit: Nb minimum de pixels al�atoires
$noisepxmax = sfConfig::get('app_cryptographp_noise_px_max', 10);      // Bruit: Nb maximum de pixels al�atoires

$noiselinemin = sfConfig::get('app_cryptographp_noise_line_min', 1);     // Bruit: Nb minimum de lignes al�atoires
$noiselinemax = sfConfig::get('app_cryptographp_noise_line_max', 0);     // Bruit: Nb maximum de lignes al�atoires

$nbcirclemin = sfConfig::get('app_cryptographp_nb_circle_min', 0);      // Bruit: Nb minimum de cercles al�atoires 
$nbcirclemax = sfConfig::get('app_cryptographp_nb_circle_max', 0);      // Bruit: Nb maximim de cercles al�atoires

$noisecolorchar  = sfConfig::get('app_cryptographp_noise_colorchar', 3);  // Bruit: Couleur d'ecriture des pixels, lignes, cercles: 
                       // 1: Couleur d'�criture des caract�res
                       // 2: Couleur du fond
                       // 3: Couleur al�atoire
                       
$brushsize = sfConfig::get('app_cryptographp_brushsize', 1);        // Taille d'ecriture du princeaiu (en pixels) 
                       // de 1 � 25 (les valeurs plus importantes peuvent provoquer un 
                       // Internal Server Error sur certaines versions de PHP/GD)
                       // Ne fonctionne pas sur les anciennes configurations PHP/GD

$noiseup = sfConfig::get('app_cryptographp_noiseup', false);      // Le bruit est-il par dessus l'ecriture (true) ou en dessous (false) 

// --------------------------------
// Configuration syst�me & s�curit�
// --------------------------------

$cryptformat = sfConfig::get('app_cryptographp_format', "png");   // Format du fichier image g�n�r� "GIF", "PNG" ou "JPG"
				                // Si vous souhaitez un fond transparent, utilisez "PNG" (et non "GIF")
				                // Attention certaines versions de la bibliotheque GD ne gerent pas GIF !!!

$cryptsecure = sfConfig::get('app_cryptographp_secure', "md5");    // M�thode de crytpage utilis�e: "md5", "sha1" ou "" (aucune)
                         // "sha1" seulement si PHP>=4.2.0
                         // Si aucune m�thode n'est indiqu�e, le code du cyptogramme est stock� 
                         // en clair dans la session.
                       
$cryptusetimer = sfConfig::get('app_cryptographp_usetimer', 0);        // Temps (en seconde) avant d'avoir le droit de reg�n�rer un cryptogramme

$cryptusertimererror = sfConfig::get('app_cryptographp_usertimererror', 3);  // Action � r�aliser si le temps minimum n'est pas respect�:
                           // 1: Ne rien faire, ne pas renvoyer d'image.
                           // 2: L'image renvoy�e est "images/erreur2.png" (vous pouvez la modifier)
                           // 3: Le script se met en pause le temps correspondant (attention au timeout
                           //    par d�faut qui coupe les scripts PHP au bout de 30 secondes)
                           //    voir la variable "max_execution_time" de votre configuration PHP

$cryptusemax = sfConfig::get('app_cryptographp_usemax', 1000);  // Nb maximum de fois que l'utilisateur peut g�n�rer le cryptogramme
                      // Si d�passement, l'image renvoy�e est "images/erreur1.png"
                      // PS: Par d�faut, la dur�e d'une session PHP est de 180 mn, sauf si 
                      // l'hebergeur ou le d�veloppeur du site en ont d�cid� autrement... 
                      // Cette limite est effective pour toute la dur�e de la session. 
                      
$cryptoneuse = sfConfig::get('app_cryptographp_oneuse', false);  // Si vous souhaitez que la page de verification ne valide qu'une seule 
                       // fois la saisie en cas de rechargement de la page indiquer "true".
                       // Sinon, le rechargement de la page confirmera toujours la saisie.                          
                      
?>
