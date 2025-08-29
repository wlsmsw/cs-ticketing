<div class="main">
    <div class="ticket-statuses">
        <div class="panel in-progress" id="header-in-progress">
            <h1><?=$open;?></h1>
            <p>IN PROGRESS</p>
        </div>
        <div class="panel on-hold" id="header-on-hold">
            <h1><?=$onhold;?></h1>
            <p>ON HOLD</p>
        </div>
        <div class="panel cancelled" id="header-cancelled">
            <h1><?=$cancelled;?></h1>
            <p>CANCELLED</p>
        </div>
        <div class="panel resolved" id="header-resolved">
            <h1><?=$resolved;?></h1>
            <p>RESOLVED</p>
        </div>
    </div>

    <div class="wrapper table-responsive">
        <table id="tblIssues" class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>Category</th>
                    <th>Username</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Channel</th>
                    <th>Email</th>
                    <th>Assigned to</th>
                    <th>Status</th>
                    <th>Date Reported</th>
                </tr>
            </thead>

            <tbody>
                
            </tbody>
        </table>
    </div>
</div>