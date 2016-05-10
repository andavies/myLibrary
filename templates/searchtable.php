<div>
    <form action="search.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" name="title" placeholder="title" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="author" placeholder="author" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="isbn" placeholder="isbn" type="text"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Search</button>
        </div>
    </fieldset>
</form>   
</div>

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
