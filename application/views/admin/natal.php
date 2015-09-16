<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Natal Chart</title>
        <link rel="stylesheet" href="<?php echo base_url('public/bower/bower_components/bootstrap/dist/css/bootstrap.min.css');?>" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url('public/bower/bower_components/bootstrap/dist/css/bootstrap-theme.min.css');?>" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url('public/bower/css/styles.css');?>" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/bower/bower_components/select2/dist/css/select2.min.css');?>">

        <script type="text/javascript">
            var CONFIG = {
                base_url: "<?php echo base_url() ?>",
                user_id: "<?php echo $user->id ?>"
            };

        </script>

        <?php if($flag == 0) { ?>
            <script type="text/javascript">
                CONFIG.url = "<?php echo base_url('admin/natal_charts/add/'.$user->id)?>";
            </script>
        <?php } else { ?>
            <script type="text/javascript">
                CONFIG.url = "<?php echo base_url('admin/natal_charts/change/'.$user->id)?>";
            </script>
        <?php } ?>
    </head>
    <body>
        <div class="" id="app-wrapper">
        </div>
        <footer>
            <!-- Third-Party -->
            <script src="<?php echo base_url('public/bower/bower_components/underscore/underscore-min.js');?>" charset="utf-8"></script>
            <script src="<?php echo base_url('public/bower/bower_components/jquery/dist/jquery.min.js');?>"></script>
            <script src="<?php echo base_url('public/bower/bower_components/bootstrap/dist/js/bootstrap.min.js');?>" charset="utf-8"></script>
            <script src="<?php echo base_url('public/bower/bower_components/backbone/backbone-min.js');?>" charset="utf-8"></script>
            <script src="<?php echo base_url('public/bower/bower_components/d3/d3.min.js');?>"></script>
            <script src="<?php echo base_url('public/bower/bower_components/select2/dist/js/select2.full.min.js');?>"></script>
            <!-- Third-Party -->

            <script type="text/javascript" src="<?php echo base_url('public/bower/src/main.js');?>"></script>
        </footer>

        <!-- Templates -->
        <script type="text/template" id="modal-template">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Natal Chart</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th class="col-sm-1">House</th>
                                        <th class="col-sm 2">Set Start</th>
                                        <th class="col-sm-9">Planets</th>
                                    </tr>
                                </tbody>
                                <% _.each(planetoryHouse, function(planet) { %>
                                    <tr>
                                        <td><%= planet.id %></td>
                                        <td>
                                            <input type="radio" value="<%= planet.id %>" checked="checked" name="set-start">
                                        </td>
                                        <td>
                                            <select type="hidden" class="col-sm-12 planets" multiple="true" name="<%= planet.id %>" >
                                            </select>
                                        </td>
                                    </tr>
                                <% }); %>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="save-chart" type="button">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </script>

        <script type="text/template" id="builder-template">
        <div class="row">
            <div class="col-md-12">
                <div class="svg-container"></div>
                <button class="btn btn-primary" id="btn-set-planets">Edit</button>
            </div>
        </div>
        </script>

        <script type="text/template" id="confirmation-template">
        <div class="row">
            <div class="col-md-12">
                <div class="svg-container"></div>
                <div id="pngdataurl"></div>
                <a href="#builder" class="btn btn-primary">Rebuild</a>
                <button type="button" id="export-to-png" class="btn btn-primary">Save Natal Chart</button>
            </div>
        </div>
        </script>
        <!-- Templates -->
    </body>
</html>