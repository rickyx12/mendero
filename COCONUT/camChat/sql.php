<?
$hostname	= 'localhost';
$sqluser	= 'root';
$sqlpass	= 'z2tue31';
$dbName		= 'Coconut';

@mysql_connect($hostname, $sqluser, $sqlpass)  or die( 'Connexion au serveur de donn�es impossible' ) ;
@mysql_select_db( $dbName ) or die( 'Unable to connect DATABASE' ) ;
?>
