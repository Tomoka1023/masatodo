<?php
require_once 'auth.php';
require_once 'db.php';

// ログインユーザーのタスクを取得
$stmt = $pdo->prepare("SELECT task, due_date FROM todos WHERE user_id = :user_id AND due_date IS NOT NULL");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>カレンダー表示</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.global.min.js"></script>
  <style>
    body {
      font-family: sans-serif;
      margin: 20px;
    }
    #calendar {
      max-width: 800px;
      margin: auto;
    }
    .fc {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 0 20px rgba(100, 100, 255, 0.2);
    }

    .fc-daygrid-day:hover {
        background-color: rgba(76, 201, 240, 0.1);
        cursor: pointer;
    }

  </style>
</head>
<body>
  <h1 style="text-align: center;">📅 カレンダー表示</h1>
  <div id="calendar"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ja',
        initialView: 'dayGridMonth',
        events: [
          <?php foreach ($todos as $todo): ?>
          {
            title: "<?= htmlspecialchars($todo['task']) ?>",
            start: "<?= $todo['due_date'] ?>"
          },
          <?php endforeach; ?>
        ]
      });
      calendar.render();
    });
  </script>
</body>
</html>
