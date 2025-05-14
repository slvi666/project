<!-- resources/views/answers/show.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jawaban</title>
</head>
<body>
    <h1>Detail Jawaban Siswa</h1>
    <p><strong>Jawaban ID:</strong> {{ $answer->id }}</p>
    <p><strong>Soal ID:</strong> {{ $answer->question_id }}</p>
    <p><strong>Jawaban:</strong> {{ $answer->answer_text }}</p>
    <p><strong>Nilai:</strong> {{ $answer->score ?? 'Belum dinilai' }}</p>
</body>
</html>
