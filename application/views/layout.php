<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css')?>"/>
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/all.min.css') ?>"/>
        <style>
            :root {
    --primary-color: #e2e8f0;
    --secondary-color: #536390;
    --font-color: #424242;
    --bg-color: #fff;
    --heading-color: #292922;
}
[data-theme="dark"] {
    --primary-color: #9A97F3;
    --secondary-color: #818cab;
    --font-color: #e1e1ff;
    --bg-color: #161625;
    --heading-color: #818cab;
}
h1 {
    color: var(--secondary-color);

}
            body{
    color: var(--font-color);
    margin-top:20px;
    color: #1a202c;
    text-align: left; 
}
.inner-wrapper {
    position: relative;
    height: calc(100vh - 3.5rem);
    transition: transform 0.3s;
}
@media (min-width: 992px) {
    .sticky-navbar .inner-wrapper {
        height: calc(100vh - 3.5rem - 48px);
    }
}

.inner-main,
.inner-sidebar {
    position: absolute;
    top: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
}
.inner-sidebar {
    left: 0;
    width: 235px;
    border-right: 1px solid #cbd5e0;
    background-color: #fff;
    z-index: 1;
}
.inner-main {
    right: 0;
    left: 235px;
}
.inner-main-footer,
.inner-main-header,
.inner-sidebar-footer,
.inner-sidebar-header {
    height: 3.5rem;
    border-bottom: 1px solid #cbd5e0;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    flex-shrink: 0;
}
.inner-main-body {
    padding: 1rem;
    position: relative;
    flex: 1 1 auto;
}
.inner-sidebar-body {
    padding: 1rem;
    overflow-y: auto;
    position: relative;
    flex: 1 1 auto;
}
.inner-main-body .sticky-top,
.inner-sidebar-body .sticky-top {
    z-index: 999;
}
.inner-main-footer,
.inner-main-header {
    background-color: #fff;
}
.inner-main-footer,
.inner-sidebar-footer {
    border-top: 1px solid #cbd5e0;
    border-bottom: 0;
    height: auto;
    min-height: 3.5rem;
}
@media (max-width: 767.98px) {
    .inner-sidebar {
        left: -235px;
    }
    .inner-main {
        left: 0;
    }
    .inner-expand .main-body {
        overflow: hidden;
    }
    .inner-expand .inner-wrapper {
        transform: translate3d(235px, 0, 0);
    }
}

.nav .show>.nav-link.nav-link-faded, .nav-link.nav-link-faded.active, .nav-link.nav-link-faded:active, .nav-pills .nav-link.nav-link-faded.active, .navbar-nav .show>.nav-link.nav-link-faded {
    color: #3367b5;
    background-color: #c9d8f0;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #467bcb;
}
.nav-link.has-icon {
    display: flex;
    align-items: center;
}
.nav-link.active {
    color: #467bcb;
}
.nav-pills .nav-link {
    border-radius: .25rem;
}
.nav-link {
    color: #4a5568;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}
            img {
                height: auto;
                width: auto;
            }
            tbody {
                font-size: 20px;
                font-weight: 300;
            }
            a {
                /* color: var(--primary-color); */
                color: inherit;
            }
            .theme-switch-wrapper {
  display: flex;
  align-items: center;
}
em {
    margin-left: 10px;
    font-size: 1rem;
  }
.theme-switch {
  display: inline-block;
  height: 34px;
  position: relative;
  width: 60px;
}
.theme-switch input {
  display:none;
}
.slider {
  background-color: #ccc;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: .4s;
}
.slider:before {
  background-color: #fff;
  bottom: 4px;
  content: "";
  height: 26px;
  left: 4px;
  position: absolute;
  transition: .4s;
  width: 26px;
}
input:checked + .slider {
  background-color: #66bb6a;
}
input:checked + .slider:before {
  transform: translateX(26px);
}
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
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