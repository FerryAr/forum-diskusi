<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css')?>"/>
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/all.min.css') ?>"/>
        <style>
            img {
                height: auto;
                width: auto;
            }
            tbody {
                font-size: 20px;
                font-weight: 300;
            }
            a {
                color: inherit;
            }
            #preloader{overflow:hidden;background:#54B4F5;left:0;right:0;top:0;bottom:0;position:fixed;z-index:9999}
#container{margin:-45px -60px;width:120px;height:90px;position:absolute;top:50%;left:50%}
#dot{background:#FFF;border-radius:50%;width:30px;height:30px;position:absolute;bottom:30px;left:27px;transform-origin:center bottom;animation:dot .6s ease-in-out infinite}
@-webkit-keyframes dot{0%{transform:scale(1,.7)}20%{transform:scale(.7,1.2)}40%{transform:scale(1,1)}50%{bottom:100px}46%{transform:scale(1,1)}80%{transform:scale(.7,1.2)}90%{transform:scale(.7,1.2)}100%{transform:scale(1,.7)}}
.step{position:absolute;width:30px;height:30px;border-top:2px solid #FFF;top:0;right:0}
@-webkit-keyframes anim{0%{opacity:0;top:0;right:0}50%{opacity:1}100%{top:90px;right:90px;opacity:0}}
#s1{animation:anim 1.8s linear infinite}
#s2{animation:anim 1.8s linear infinite -.6s}
#s3{animation:anim 1.8s linear infinite -1.2s}
        </style>
    </head>
    <body>