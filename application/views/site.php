<hr />
<h1>Gestion du site</h1>
<hr />
<h2>Titre du site :</h2>
<hr />
<input id="changeTitle" type="text" value="<?php echo $title; ?>" /><input type="submit" value="Modifier" onclick="changeTitle()" />
<hr />
<h2>Données du site :</h2>
<ul id="listOfServerFonctinnality">
<hr />
	<li><label for="ts3">Adresse du ts3 :</label><input id="ts3" type="text" value="<?php echo $adress[0]->value;?>" /><input type="submit" value="Modifier" onclick="" /></li>
	<li><label for="transmission">Adresse du transmission :</label><input id="transmission" type="text" value="<?php echo $adress[1]->value; ?>" /><input type="submit" value="Modifier" onclick="" /></li>
	<li><label for="plex">Adresse du Plex :</label><input id="plex" type="text" value="<?php echo $adress[2]->value; ?>" /><input type="submit" value="Modifier" onclick="" /></li>
	<li><label for="server">Adresse du server : </label><input id="server" type="text" value="<?php  echo $adress[3]->value; ?>" /><input type="submit" value="Modifier" onclick="" /></li>
	<li><label for="webmin">Adresse de webmin : </label><input id="webmin" type="text" value="<?php  echo $adress[4]->value; ?>" /><input type="submit" value="Modifier" onclick="" /></li>
</ul>