
        </div>
        
    </main>


    <footer>
        <p>&copy; Megasportsworld 2024.</p>
    </footer>

    <!-- modals -->
    <div class="modal fade" id="resolved-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Portal Ticket #: <span id="msw-ticket-modal">MSW-0001</span></h5>

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="table-group">
                            <div class="ticket-details"></div>
                        </div>

                        <div class="form-holder">
                            <h4>Resolve Ticket</h4>
                            
                            <form id="frmResolve" method="post">
                                <div class="alert alert-danger warning" hidden="">
                                    Please complete fields
                                </div>
                                
                                <input type="hidden" name="ticket">
                                <input type="hidden" name="completed_id">
                                <input type="hidden" name="completed_dept">
                                <input type="hidden" name="mainsub">
                                <input type="hidden" name="subsub">
                                <input type="hidden" name="outletname">
                                
                                <div class="form-group">
                                    <label for="txtDate">Resolve Date :</label>
                                    <div class="input-holder">
                                        <input type="date" class="form-control" name="resolved_date" max="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" required="">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="txtTime">Resolve Time :</label>
                                    <div class="input-holder">
                                        <input type="time" class="form-control" name="resolved_time" value="<?=date('H:i')?>" required="">
                                    </div>
                                </div>
                                
                                <div class="form-group" id="resolution_radio">
                                    <label for="resolution_type">Resolution Type :</label>
                                    <div class="input-holder">
                                        
                                        <label class="radioLbl"><input type="radio" name="resolution_type" id="reso_ama" value="2">AMA</label>
                                        <label class="radioLbl"><input type="radio" name="resolution_type" id="reso_cms" value="4">CMS</label>
                                        <label class="radioLbl"><input type="radio" name="resolution_type" id="reso_csa" value="1">CSA</label>
                                        <label class="radioLbl"><input type="radio" name="resolution_type" id="reso_fra" value="5">FRA</label>
                                        <label class="radioLbl"><input type="radio" name="resolution_type" id="reso_onsite" value="3">RDA</label>

                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <label for="ddlDevice">Completed By :</label>
                                    <div class="input-holder ddevice">
                                        <span class="form-control" id="completed_by" name="completed_by"></span>   
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="txtRemarks">Justification/Remarks :</label>
                                    <textarea class="form-control" id="txtRemarks" name="remarks_txt" required=""></textarea>
                                </div>
                                
                                <div class="form-group btn-holder">
                                    <button type="submit" class="btn btn-primary btn-block mt-1">Resolve</button>
                                    <button type="reset" class="btn btn-primary btn-block mt-1">Clear</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="<?=base_url('assets/js/rty-modal-1.2.5.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.datatables.min.js'); ?>"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script src="<?=base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js'); ?>"></script>

    <script type="text/javascript">var base_url = "<?=base_url()?>";</script>
    <script type="text/javascript" src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script src="<?=base_url('assets/js/cs-ticketing-scripts.js')?>"></script>

    <?php if(isset($report_chart)){ ?>
    <script>

    /* Charts */
    var x = <?php echo($report_chart); ?>;

    window.onload = function () {
        
        CanvasJS.addColorSet("customColorSet1",
                    [
                        "#ffc107",
                        "#28a745",
                        "#007bff"
                    ]);
                    
        x.render();
    }

    </script>
    <?php }?>

</body>
</html>