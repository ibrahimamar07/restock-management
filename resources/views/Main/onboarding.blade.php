<!-- Muhammad Kevin Checa Satrio - 5026221083 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup</title>
    <link rel="stylesheet" href="onboarding.css">
</head>

<body>
    <div class="page-container">

        <h1 class="title">Let’s set things up</h1>

        <h2 class="subtitle">
            What do <span class="highlight">you</span> want<br>
            to do with this app?
        </h2>

        <div class="option-box">

            <a href="{{ route('stores.index') }}">
                <button class="option top">
                    I want to find people to restock my store
                </button>
            </a>

            <button class="option bottom">
                I want to find stores that needs restocking
            </button>

        </div>

    </div>
</body>
</html>
