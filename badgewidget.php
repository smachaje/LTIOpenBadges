    <tr><td colspan=2 align=left valign=top><b><?PHP echo $groupname; ?></b><hr /></td></tr>

<?PHP

$bdata = get_badges($userid, $group);

	$j=0;
            while ($j < count($bdata[badges]) )
            {
                $badgeName = $bdata[badges][$j][assertion][badge][name];
                $imgUrl = $bdata[badges][$j][assertion][badge][image];
                $critUrl = $bdata[badges][$j][assertion][badge][criteria];
                $assertUrl = $bdata[badges][$j][hostedUrl];
		if (strpos($imgUrl,"http") === false)
		{ $imgUrl = $bdata[badges][$j][assertion][badge][issuer][origin].$imgUrl; }

		echo "<tr><td align='center'>";
		echo "<tr><td align=left valign=top>";
		echo "<a href='$critUrl'>";
		echo "<img width=100 height=100 src='$imgUrl' border=0 /><br /></a>";
		echo "</td><td valign=top><b>".($j+1).". $badgeName</b><br /><br />".$bdata[badges][$j][assertion][badge][description];
		echo "<br /><br /><p align=right >Issued by <a href='$critUrl'>";
		echo $bdata[badges][$j][assertion][badge][issuer][name];
		echo "</a></p></td></tr>";



                $j = $j+1;
        }

?>
