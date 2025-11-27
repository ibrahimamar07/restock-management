{{-- felix prajna santoso 5026231027 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Store - Restocking</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background: linear-gradient(180deg, #1a237e 0%, #0d1642 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        
        .header {
            background-color: #000;
            height: 30px;
            border-radius: 20px 20px 0 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            font-size: 12px;
            color: #fff;
        }
        
        .notch {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 25px;
            background-color: #000;
            border-radius: 0 0 15px 15px;
        }
        
        .screen {
            background: linear-gradient(180deg, #1e2a5e 0%, #0f1535 100%);
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .content {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        h1 {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
        
        .highlight {
            background: linear-gradient(90deg, #5dd9e8 0%, #4fc3f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Status bar icons */
        .status-left {
            display: flex;
            gap: 5px;
        }
        
        .status-right {
            display: flex;
            gap: 5px;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Phone Header -->
        <div class="header">
            <div class="status-left">
                <span>9:41</span>
            </div>
            <div class="notch"></div>
            <div class="status-right">
                <span>📶</span>
                <span>📡</span>
                <span>🔋</span>
            </div>
        </div>
        
        <!-- Screen Content -->
        <div class="screen">
            <div class="content">
                <h1>
                    LET'S FIND<br>
                    SOME STORE<br>
                    THAT NEEDS<br>
                    <span class="highlight">RESTOCKING</span>
                </h1>
            </div>
        </div>
    </div>
</body>
</html>