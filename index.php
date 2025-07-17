<?php
require_once 'auth.php';
require_once 'db.php';

// タスク取得
$stmt = $pdo->prepare("SELECT * FROM todos WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ToDoリスト</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>
    <style>
        .tabs {
            text-align: center;
            margin-bottom: 20px;
        }
        .tab-button {
            background: linear-gradient(135deg, #3a0ca3, #7209b7, #4361ee);
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 0 10px #7209b7;
            transition: all 0.3s ease;
        }

        .tab-button:hover {
            box-shadow: 0 0 15px #4cc9f0;
        }

        .tab-button.active {
            background: #4cc9f0;
            color: #000;
            font-weight: bold;
        }

        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        #calendar {
            max-width: 800px;
            margin: auto;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">ToDoアプリ</h1>
<p style="text-align: center;"><a href="logout.php">ログアウト</a></p>

<!-- タブ -->
<div class="tabs">
    <button class="tab-button active" data-tab="list">📝 リスト表示</button>
    <button class="tab-button" data-tab="calendar">📅 カレンダー表示</button>
</div>

<!-- タブ1：リスト -->
<div id="tab-list" class="tab-content active">
    <!-- タスク追加フォーム -->
    <form action="add.php" method="post" style="text-align: center;" id="task-form">
        <input type="text" name="task" placeholder="新しいタスク" required>
        <input type="date" name="due_date" id="due-date">
        <button type="submit">追加</button>
    </form>

    <ul>
        <?php foreach ($todos as $todo): ?>
        <li>
            <!-- 完了ボタン -->
            <form action="done.php" method="post" style="display: inline;">
                <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                <button type="submit"><?= $todo['is_done'] ? "🔄 未完了" : "✅ 完了" ?></button>
            </form>

            <!-- タスク表示 -->
            <?= $todo['is_done'] ? "<s>" . htmlspecialchars($todo['task']) . "</s>" : htmlspecialchars($todo['task']) ?>
            <?php if ($todo['due_date']): ?>
                <small>(期限: <?= $todo['due_date'] ?>)</small>
            <?php endif; ?>

            <!-- 削除ボタン -->
            <form action="delete.php" method="post" style="display: inline;" onsubmit="return confirm('削除しますか？');">
                <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                <button type="submit">🗑 削除</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- タブ2：カレンダー -->
<div id="tab-calendar" class="tab-content">
    <div id="calendar"></div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));

    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.classList.add('active');
}

// カレンダー表示
let calendar;

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ja',
        events: [
            <?php foreach ($todos as $todo): ?>
            {
                title: "<?= htmlspecialchars($todo['task']) ?>",
                start: "<?= !empty($todo['due_date']) ? $todo['due_date'] : substr($todo['created_at'], 0, 10) ?>",
                allDay: true
            },
            <?php endforeach; ?>
        ],
        dateClick: function(info) {
    // カレンダーの日付がクリックされたら…
    document.getElementById('due-date').value = info.dateStr;

    // リストタブを自動で開く（オプション）
    document.querySelector('.tab-button[data-tab="list"]').click();
  }
});
});


// タブ切り替え処理
document.querySelectorAll('.tab-button').forEach(button => {
  button.addEventListener('click', function () {
    // 全タブ非表示・非アクティブに
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

    // 選ばれたタブを表示
    const target = this.getAttribute('data-tab');
    this.classList.add('active');
    document.getElementById('tab-' + target).classList.add('active');

    // カレンダータブが表示されたら再描画
    if (target === 'calendar') {
      setTimeout(() => {
        calendar.render();
      }, 0); // 確実に表示後に呼ぶ（非表示→表示が終わってから）
    }
  });
});
</script>

</body>
</html>
