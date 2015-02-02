<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="bjqs-1.3.js"></script>

    <style type="text/css">

        a:focus {
            outline:1px dotted #999;
        }
        /* Basic jQuery Slider essential styles */
         ul.bjqs {
            position:relative;
            list-style:none;
            padding:0;
            margin:0;
            overflow:hidden;
            display:none;
        }
        li.bjqs-slide {
            display:none;
            position:absolute;
        }
        ul.bjqs-controls {
            list-style:none;
            margin:0;
            padding:0;
            z-index:9999;
        }
        ol.bjqs-markers {
            list-style:none;
            margin:0;
            padding:0;
            z-index:9999;
        }
        ol.bjqs-markers li {
            float:left;
        }
        p.bjqs-caption {
            display:block;
            width:100px;
            margin:0;
            padding:2%;
            position:relative;
            bottom:0;
        }
        /* demo styles */

        #banner {
            height:300px;
            width:700px;
            margin:0 auto;
            position:relative;
            background:#fff;
            border:2px #000 solid;
    
        }
        ul.bjqs-controls li a {
            display:block;
            padding:5px 10px;
            position:absolute;
            background:#fff;
            color:#fd0100;
            text-decoration:none;
            text-transform:uppercase;
        }
        li.bjqs-slide div {
            background-color:#EEE;
            border:2px solid #000;
            height:200px;
        }
        a.bjqs-prev {
            left:0;
        }
        a.bjqs-next {
            right:0;
        }
        p.bjqs-caption {
            background:rgba(0, 0, 0, 0.7);
            color:#fff;
            text-align:center;
        }
        ol.bjqs-markers {
            position:absolute;
            bottom:-50px;
        }
        ol.bjqs-markers li {
            float:left;
            margin:0 3px;
        }
        ol.bjqs-markers li a {
            display:block;
            height:10px;
            width:10px;
            border:4px solid #fff;
            overflow:hidden;
            text-indent:-9999px;
            background:#000;
            border-radius:10px;
            box-shadow:0 0 50px rgba(0, 0, 0, 0.5);
        }
        ol.bjqs-markers li.active-marker a {
            background:#fd0100;
        }

        ul.bjqs {
            text-align:center;
        }

        ul.bjqs img {
            width:100%;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function (e) {

            $('#banner').bjqs({
                'animation': 'slide',
                'width': 700,
                'height': 300,
                'automatic': true,
                'animspeed': '3000',
                'showControls': true,
                'centerControls': true,
                'centerMarkers': false,
                'useCaptions': true,
                'loop': 1 // this will loop once and stop at first slide
            });

            $(function () {
                $("#banner").resizable();
            });
        });
    </script>
</head>
<body>
    <div id="banner">
        <!-- start Basic Jquery Slider -->
        <ul class="bjqs">
            <li>
                <img src="http://2.bp.blogspot.com/_irPxcWyLEmo/TP8k1GUp3LI/AAAAAAAAAD0/wIGvKoqhb-M/s320/African_Lion_King.jpg" title="lion" />
            </li>
            <li>
                <img src="http://static.tumblr.com/27c8612a25c299f98004c15b155cefad/ogbqjed/k2Bmmp0ut/tumblr_static_giraffes_wallpapers_156.jpg" title="giraffe" />
            </li>
            <li>
                <img src="http://embc.gov.bc.ca/em/hazard_preparedness/wildlife_info_page_photo-05-large.jpg" title="bear" />
            </li>
        </ul>
        <!-- end Basic jQuery Slider -->
    </div>
    <!-- End outer wrapper -->
</body>
</html>
                                        