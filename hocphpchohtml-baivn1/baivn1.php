<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>In Dãy Số Từ 1 đến 100 với PHP</title>
    <style>
        /* Định nghĩa style cho số chẵn */
        .so-chan {
            color: red; /* Màu đỏ */
            font-weight: bold; /* In đậm */
        }
        
        /* Định nghĩa style cho số lẻ */
        .so-le {
            color: green; /* Màu xanh */
            font-weight: bold; /* In đậm */
            font-style: italic; /* In nghiêng */
        }
    </style>
</head>
<body>

    <h2>Dãy số từ 1 đến 100</h2>
    
    <?php
    // Bắt đầu vòng lặp từ 1 đến 100
    for ($i = 1; $i <= 100; $i++) {
        
        // Kiểm tra số chẵn (Số chia hết cho 2 có số dư là 0)
        if ($i % 2 == 0) {
            // Số chẵn: In đậm và màu đỏ (red)
            echo "<span class='so-chan'>" . $i . "</span>";
        } 
        // Nếu không phải số chẵn, thì là số lẻ
        else {
            // Số lẻ: In đậm, nghiêng và màu xanh (green)
            echo "<span class='so-le'>" . $i . "</span>";
        }
        
        // Thêm dấu phẩy và khoảng trắng giữa các số, trừ số cuối cùng
        if ($i < 100) {
            echo ", ";
        }
    }
    ?>

</body>
</html>