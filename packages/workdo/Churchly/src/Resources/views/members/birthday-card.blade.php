<div style="width:800px; height:1000px; 
    background: linear-gradient(180deg, #0f2c5c, #4b6cb7); 
    color:white; 
    text-align:center; 
    font-family:'Poppins', sans-serif; 
    position:relative; 
    border-radius:20px; 
    overflow:hidden; 
    box-shadow:0 10px 25px rgba(0,0,0,0.4);">

    <!-- Header -->
    <h3 style="padding-top:40px; letter-spacing:4px; font-size:18px; font-weight:500; margin:0;">
        CHRIST CHURCH EVANGELISM MINISTRIES
    </h3>

    <h1 style="font-size:70px; margin:30px 0 10px; font-weight:900; text-transform:uppercase;">
        Happy <span style="color:#ffd700;">Birthday</span>
    </h1>

    <!-- Profile photo -->
    <div style="margin:30px auto; width:280px; height:280px; border-radius:50%; 
        overflow:hidden; border:12px solid #ffd700; box-shadow:0 6px 20px rgba(0,0,0,0.5);">
        <img src="{{ $photoUrl }}" style="width:100%; height:100%; object-fit:cover;">
    </div>

    <!-- Name -->
    <h2 style="margin-top:15px; font-size:34px; font-weight:600;">
        Min. <span style="font-weight:800; color:#ffd700;">{{ strtoupper($name) }}</span>
    </h2>

    <!-- Message -->
    <p style="margin:20px auto; max-width:600px; font-size:18px; line-height:1.6; color:#f1f1f1;">
        🎉 THIS IS YOUR YEAR OF <span style="color:#ffd700; font-weight:bold;">TOTAL RECOVERY</span>, 
        <span style="color:#ffd700; font-weight:bold;">REALIGNMENT</span> AND 
        <span style="color:#ffd700; font-weight:bold;">REASSURANCE</span>. 🎉
    </p>

    <!-- Decorative divider -->
    <div style="width:60%; height:2px; background:#ffd700; margin:30px auto;"></div>

    <!-- Footer -->
    <div style="position:absolute; bottom:0; left:0; right:0; 
        background:#0a1a33; padding:15px; font-size:14px; letter-spacing:1px; color:#ddd;">
        <img src="{{ asset('images/church-logo.png') }}" 
             style="height:45px; vertical-align:middle; margin-right:15px;">
        <span>www.cce-ministries.org | +1 (204) 504 2847</span>
    </div>
</div>
