<!-- Starting point of a new service: email notice on new_ticket proposed by Patrick Allaire -->
<p>Une demande d'intervention a été déposée depuis l'adresse <?php echo URL::to(); ?></p>
<p>Le contenu est:</p>
<p><?php echo $contenu; ?> </p>
--------------------------------
<p>l'auteur</p>
<p><?php echo $auteur; ?></p>
--------------------------------
<p>le titre</p>
<p><?php echo $titre; ?></p>
--------------------------------
<p>le projet</p>
<p><?php echo $projet; ?></p>