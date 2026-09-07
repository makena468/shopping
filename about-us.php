<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Learn about Shopping, our mission, and the customer-first experience we offer." />
        <meta name="author" content="Shopping" />
        <title>Shopping | About Us</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">About Us</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="text-justify">
                            <p class="lead mb-4">
                                E-commerce is changing the way people shop in Nairobi and beyond. Instead of visiting multiple
                                stores to find the latest phone or essential household item, you can discover what you need from
                                the comfort of your home in just a few clicks.
                            </p>
                            <p class="mb-4">
                                From mobile devices and electronics to fashion, furniture, home essentials, appliances, and
                                lifestyle products, Shopping brings together a wide range of categories under one digital store.
                                Whether you are looking for everyday essentials or premium picks, you can explore a curated
                                selection designed to make online shopping simple, fast, and enjoyable.
                            </p>
                            <p class="mb-4">
                                We understand that modern lifestyles are busy, which is why our platform is built for convenience.
                                Shop anytime, whether late at night or early in the morning, and enjoy a seamless buying
                                experience without the limits of store hours.
                            </p>
                            <p class="mb-0">
                                With seasonal deals, promotional offers, and competitive prices throughout the year, we aim to
                                deliver value without compromising on quality. If you are choosing where to shop online, we are
                                here to make that decision easy, reliable, and rewarding.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once('includes/footer.php'); ?>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
