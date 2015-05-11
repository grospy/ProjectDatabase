<?PHP
session_start();
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}
require("include/top.php");
?>

<div class="dash">
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?></p>
    <!--<p>Registration deadline:</p>-->
    <!--<p>Credits:?></p>-->
    <p><a href="logout.php">Log out</a></p>
<!--==================================================-->
    <div class="tabs">

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-1" name="tab-group-1">
            <label class="tab-label" for="tab-1">Grades</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Grades</h3>
                    <?php require('include/grades.php');?>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" checked>
            <label class="tab-label" for="tab-2">Enroll</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>What is this devilry?</h3>
                    <p>First of all we are working with inline content here and being smart about it. We eliminate white space using the dirty but sufficient zero font-size.</p>
                    <p>There is one additional element in comparison to what Chris had: <code>.tab-panel</code> element, which works as a container for the <code>.tab-content</code> element. The panel is inline-block by default, which means it can take styles like overflow, position, and width and height. We set these to zero size, use <code>overflow: hidden;</code> and <code>position: relative;</code> so that <code>.tab-content</code> disappears. For the active tab we do only one style change and it happens to the <code>.tab-panel</code> element: we make it inline! Thus it no longer follows the other rules that bind inline-block. As a result it's child element will start following the flow of the next container element up in the tree.</p>
                    <p>As for the <code>.tab-content</code> element it is floated and has a width of 100%. The neat thing about this combination is that it forces the element to go below the row where you can see the tab buttons.</p>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
            <label class="tab-label" for="tab-3">-----</label>
            <div class="tab-panel">
                <div class="tab-content">
                    <h3>The support must be poor!</h3>
                    <p>The CSS only part of this solution works in Internet Explorer 9+. All the other browsers are supported from so far back that it is enough to tell this works on Firefox, Chrome, Safari and Opera.</p>
                    <p>The JavaScript is quite simple and it is for IE8 and below. It does no harm to other browsers, but you probably want to hide it behind IE conditional comments: <code>&lt;!--[if lte IE 8]&gt; &hellip; &lt;![endif]--&gt;</code></p>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-4" name="tab-group-1">
            <label class="tab-label" for="tab-4">Description</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Supporting the old</h3>
                    <p>Internet Explorer 8 and below do not support the required <code>:checked</code> selector. This is why there is some JavaScript. It doesn't do a whole lot really: the active <code>.tab</code> element gets class <code>checked</code> and then we use that in CSS.</p>
                    <p>Due to redrawing issues in IE8 we avoid using selectors like + and ~ with it. And this is also the reason we set class to the <code>.tab</code> element and not the radio button.</p>
                    <p>The most interesting thing with styling in IE8 and below is to keep the input element on the page: if the element is hidden using <code>display: none;</code> then we never get the click events. To achieve a hidden input we position it absolutely and use IE proprietary Alpha filter to make it invisible. Then finally <code>z-index</code> throws it behind so it can't be clicked. To target the element properly an additional class of <code>.tab-radio</code> is added to the radio button. It is for IE8- only.</p>
                    <p>All IE8- styles are within one media query so it's easy to remove it. It is also easy to remove IE7 and IE6 only styles by following the comments.</p>
                </div>
            </div>
        </div>

    </div>

<!------------------------------------------------------------------>
<?php
require("include/bot.php");
?>
