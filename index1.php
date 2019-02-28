<?php
$username="";  //nom d'utilisateur de base
$dbpass="";      // mots de passe de la base
$dbname="AIS"; //nom de la source de données avec description de la base de données
$link=odbc_connect($dbname,$username,$dbpass);    //connexion à la base de données
if(!$link) exit("Erreur de connection a la base de donnée");    //erreur de connexion
$number=$_POST['number']; //lecture de la valeur du champ du numéro de compte de l'étudiant
$zapros="SELECT [table etudiant].* FROM [table etudiant] WHERE [table etudiant].[code de l'etudiant]=$number;"; //demande de recherche

$rezult=odbc_exec ($link,$zapros);//demande d'exécution                                  
if(!$rezult)  exit ("Erreur d'execution de la requete"); //demande a échoué                            
$i=0;
while  (odbc_fetch_row ($rezult)) //cycle de lecture de requête
{ if ($i==0) //premier enregistrement de la requête, la formation du nom de la table
     {   $f=odbc_result($rezult, "Nom") . ", Groupe " . odbc_result($rezult, "Groupe") ;
         echo "<br> <b> <p align='center'>$f</b>";  $i=1;
         echo '<table border="1">'; //formation de l'en-tête de la table de performance
         echo "<tr><b><td align='center' valign='top' ><b>№</b><td><b>Semestre
         <td   align='center' valign='top' ><b>Discipline</b>
         <td align='center' valign='top' ><b>Moyene</b>
         <td align='center' valign='top' ><b>Date</b>
         <td align='center' valign='top' ><b>Enseignant</b>",
          
      } //formation de la ligne suivante du tableau avec les données relatives au test de formation
   $semsetr=odbc_result($rezult, "Semestre");        
   $discip=trim(odbc_result($rezult, "Discipline"));                
   $ocenka=odbc_result($rezult, "Moyene");        
   if ($ocenka==0) $ocenka="";
   $dr=odbc_result($rezult, "Date t'obtenssion des resultats");        
   if ($dr) //formatage de date
       { $dr2=$dr. "0000000000";
         $dr2=substr($dr2,8,2) . "." . substr($dr2,5,2) . "." . substr($dr2,0,4);
        }
   else $dr2=""; 
   $prepod=trim(odbc_result($rezult, "NomEnseignant"));        
   $sost=trim(odbc_result($rezult, "Commentaire"));        
   echo "<tr><td align='Center'>$i<td align='Center'>$semsetr<td>$discip<td>$ispit<td align='Center'>$ocenka<td>$dr2<td>$prepod<td  align='Center'>$sost"; 
   $i=$i+1;
}
if ($i==0) echo ("Il n’existe aucun enregistrement de progression d’étudiant avec le numéro de compte spécifié!");
odbc_close($link); //fermeture de la base de données
?>