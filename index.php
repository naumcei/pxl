<html>

    <head>
        <title>Prime Years</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>

    <body>
        <!-- Here is the Navigation bar from bootstrap -->
        <nav class="navbar navbar-default nav">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Pxl</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Prime Year</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <!-- body style from bootstrap -->
        <div class="container body-content">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="form_post.php" class="form-horizontal" name="form" id="form">
                            <div class="form-group">
                                <label class="control-label col-md-3" for="field">Please Enter Year:</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" value="2018" id="field" name="year"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-10">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="alert" class="alert hide">
                    <strong>Success!</strong> successful action.
                </div>
                <div id="action-result">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Prime Year</th>
                                <th>Crypt</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>

                </div>
            </div>
            <hr/>
            <footer>
                <p>© <?php echo date("Y") ?> - Naumche Ivanovski</p>
            </footer>
        </div>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <!-- Bootstrap jQuery library -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <!-- jQuery validate -->
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
        <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>

        <!-- My own custom jQuery -->
        <script>
            $(function () {
                // Initialize form validation.
                $("#form").validate({
                    rules: {
                        field: {
                            required: true,
                            number: true,
                            range: [1, 4000],
                            digits: true
                        }
                    },
                    highlight: function (element) {
                        $(element).parent().addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).parent().removeClass('has-error');
                    },
                    errorElement: 'span',
                    errorClass: 'help-block',
                    errorPlacement: function (error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    }
                })
                $('#form').submit(function (e) {
                    e.preventDefault();

                    var $form = $(this);
                    if (!$form.valid())
                        return;
                    message.hide();

                    let $result_container = $('#action-result tbody');
                    $result_container.empty();

                    $.ajax({
                        type: $form.attr('method'),
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function (data) {
                            if (data.error == true) {
                                message.show(1, data.message);
                                return;
                            }

                            $rows = "";
                            $.each(data, function (index, value) {

                                console.log("value", value);
                                $rows += "<tr class='infxo'>\n\
                                                <td><p>" + value.year + "</p></td>\n\
                                                <td><p>" + value.decrypt + "</p></td>\n\
                                        </tr>";
                            });

                            $result_container.append($rows);
                            message.show(0, data.message);

                        },
                        error: function (xhr, textStatus, errorThrown) {

                            message.show(1, "Error " + xhr.responseText + " received.");
                        }
                    });
                });
                var message = {
                    show: function (hasError, messageText) {
                        let $element = $('#alert');
                        if (!messageText) {
                            message.hide();
                            return;
                        }
                        if (!$element) {
                            alert(messageText);
                            return;
                        }
                        $element.empty().html(messageText).removeClass('hide');
                        hasError && $element.addClass('alert-danger') || $element.addClass('alert-success');

                    },
                    hide: function () {
                        let $element = $('#alert');
                        if (!$element)
                            return;
                        $element.empty().addClass('hide').removeClass('alert-danger alert-success');
                    }
                }
            });

        </script>

    </body>

</html>