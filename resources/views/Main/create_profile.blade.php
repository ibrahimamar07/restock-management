<!-- Muhammad Kevin Checa Satrio - 5026221083 -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Profile</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- External CSS -->
  <link rel="stylesheet" href="create-profile.css">

  <style>
    /* inline styles only for the clickable avatar overlay behavior */
    .profile-icon-wrapper {
      position: relative;
      display: inline-block;
      cursor: pointer;
      border-radius: 50%;
      overflow: hidden;
      width: 120px;
      height: 120px;
      background-color: #DFF7FF; /* show pale blue background when not pressed */
    }

    .profile-icon-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* make the + overlay fill the entire circular avatar and center the plus */
    .profile-add {
      position: absolute;
      inset: 0; /* full-cover of the wrapper */
      border-radius: 50%;
      background: rgba(255,255,255,0.85);
      color: #007374;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 48px; /* large plus that fills the circle visually */
      line-height: 1;
      opacity: 0;
      transition: opacity .14s ease;
      pointer-events: none; /* keep label clickable */
    }

    .profile-icon-wrapper:hover .profile-add {
      opacity: 0.65; /* faint overlay with centered plus on hover */
    }

    /* keep hidden file input visually hidden but accessible */
    .visually-hidden-input {
      position: absolute;
      left: -9999px;
      width: 1px;
      height: 1px;
      overflow: hidden;
    }
  </style>
</head>

<body>

  <!-- Top Section -->
<form action="{{ route('saveProfile') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="container text-center py-5 top-section">

    <!-- clickable wrapper triggers file picker -->
    <label for="profileImageInput" class="profile-icon-wrapper mx-auto mb-3" title="Change profile picture">
        <img id="profileImagePreview"
             src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png"
             class="img-fluid rounded-circle"
             alt="icon">
        <span class="profile-add">+</span>
    </label>

    <!-- IMPORTANT: name="profilepic" so Laravel receives it -->
    <input id="profileImageInput"
           name="profilepic"
           class="visually-hidden-input"
           type="file"
           accept="image/*">

    <h2 class="title">
      Create <span class="highlight">Profile</span>
    </h2>
</div>

<!-- Form Section -->
<div class="container form-section">

    <label class="form-label text-light">Nickname</label>
    <input type="text"
           name="nickname"
           class="form-control mb-3"
           placeholder=""
           required>

    <label class="form-label text-light">Description</label>
    <textarea name="description"
              class="form-control textarea mb-4"
              rows="5"></textarea>

    <button type="submit" class="btn btn-next w-100 text-center">Next</button>

</div>
</form>

<script>
  // preview selected image
  document.getElementById('profileImageInput').addEventListener('change', function (e) {
    const file = this.files && this.files[0];
    if (!file || !file.type.startsWith('image/')) return;

    const img = document.getElementById('profileImagePreview');
    const url = URL.createObjectURL(file);
    img.src = url;

    img.onload = () => URL.revokeObjectURL(url);
  });
</script>

</body>
</html>
