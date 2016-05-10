<div>
    Book added to yourBooks:
</div>

<div align="center">
    <table style="width:50%">
        <tr align="left">
            <td><img src=" <?= $book -> imageLinks -> thumbnail ?> " /> </td>
            <td><?= $book -> title ?></td>
            <td><?= $book -> authors[0] ?></td>
            <td style="width: 100px, word-wrap:break-word"><?= $book -> description ?></td>
        </tr>
    </table>
</div>

