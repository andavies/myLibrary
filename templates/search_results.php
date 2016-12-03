<?php
    include('search_form.php');
?>



<div align="center">
    <table style="width:50%, table-layout:fixed">
        
        </tr>

        <?php foreach ($rows as $row): ?>

        <tr align="left">
            <td><img src=" <?= $row['thumb'] ?> " /></td>
            <td><?= $row["title"] ?></td>
            <td><?= $row["author"] ?></td>
            <td style="width: 100px, word-wrap:break-word"><?= $row["description"] ?></td>
            <td><?= $row["ownername"] ?></td>
            <td><?= $row["availability"] ?></td>
        </tr>

        <?php endforeach ?>

    </table>
</div>
