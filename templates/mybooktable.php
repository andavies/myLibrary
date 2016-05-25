<div>
    <!-- My books:  -->
</div>

<div align="center">
    <table style="width:50%">
    
        <?php foreach ($rows as $row): ?>

        <tr align="left">
            <td><img src=" <?= $row['thumb'] ?> " /></td>
            <td><?= $row["title"] ?></td>
            <td><?= $row["author"] ?></td>
            <td><?= $row["availability"] ?></td>
            <td>
                <form action="mybooks.php?<?=$row['id']?>" method="post">              
                    <select name="availability">
                        <option value="available">available</option>
                        <option value="on loan">on loan</option>
                    </select>
            </td>
            <td>    
                    <input type="submit" value="change availability">
                </form>
            </td>
            <td><form action="mybooks.php" method="post"><button name="delete" type="submit" value="<?= $row['id'] ?>">delete</button></form>
        </tr>

        <?php endforeach ?>
        
    </table>
</div>


