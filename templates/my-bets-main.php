<main>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <?php if (!empty($bets)): ?>
        <table class="rates__list">
            <?php foreach ($bets as $bet): ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $bet["lot_image"];?>" width="54" height="40" alt="<?= $bet["lot_title"]; ?>">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?= $id; ?>""><?= $bet["lot_title"]; ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= $bet["category_name"];?>
                </td>
                <td class="rates__timer">
                    <?php $res = get_time_left($bet["date_finish"]) ?>
                    <div class="timer <?php if ($res[0] < 1 && $res[0] != 0): ?>timer--finishing <?php elseif($res[0] == 0): ?>timer--end<?php endif; ?>">
                        <?php if ($res[0] != 0): ?>
                            <?= "$res[0] : $res[1]"; ?>
                        <?php else: ?>
                            Торги окончены
                        <?php endif; ?>
                    </div>
                </td>
                <td class="rates__price">
                    <?= format_price($bet["start_price"]);?>
                </td>
                <td class="rates__time">
                    <?= $bet["bet_date"]; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </section>
</main>
