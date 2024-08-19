<?php
// This file will be the footer of the website, it contains the social media links
// a menu with the links to the different sections of the website
// a button to go to the top of the page
// the logo of the website, and the
?>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section" id="contact">
            <div class="logo">
                <a href="/">
                </a>
            </div>
            <p> 
                I'm passionate about creating websites and applications that are user-friendly and accessible. Are you looking for a developer? Let's work together!
            </p>
            <!-- Button for get in touch -->
            <button class="btn-feat contact">contáctame</button>
        </div>
        <div class="footer-section">
            <h3>Links</h3>
            <ul>
                <li><a href="#about" class="linker">About me</a></li>
                <li><a href="#skills" class="linker">My skills</a></li>
                <li><a href="#projects" class="linker">Projects</a></li>
                <li><a href="#contact" class="linker">Contact</a></li>
                <li><a href="#blog" class="linker">Blog</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Follow me</h3>
            <div class="social-footer">
                <ul>
                    <li><a href="/" class="linker"><span class="linkedin"></span>Linkedin</a></li>
                    <li><a href="/" class="linker"><span class="github"></span>Github</a></li>
                    <li><a href="/" class="linker"><span class="facebook"></span>Facebook</a></li>
                    <li><a href="/" class="linker"><span class="instagram"></span>Instagram</a></li>
                </ul>
            </div>  
        </div>
        
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php 
            $date = date('Y');
            echo $date;
        ?> - All rights reserved</p>
    </div>
    <!-- Another div with decoration and a button to go to the top of the page -->
    <div class="footer-decoration">
        <button class="btn">Go to the top of the page <span class="arrow-up"></span></button>
    </div>

</footer>
