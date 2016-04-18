<?php
class Actions_model extends MY_Model {
	

	// GETS

function get_actions1($company_id)
{
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where_not_in('action_type_id', $category_exclude);
    $this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
    
}

function get_actions($company_id)
{
            $sql = "select distinct
    c.id,
    ec.id as id,
    ec.name as campaign_name,
    con.id as contact_id,
    con.first_name,
    con.last_name,
    ec.date_sent,
    u.image,
    u.name,
    ec.created_at,
    20 AS action_type_id,
    ec.date_sent as actioned_at,
    'email campaign' as comments
    from email_campaigns ec
    left join email_actions ea on ec.id = ea.email_campaign_id
    left join contacts con on ea.contact_id = con.id
    left join companies c on con.company_id = c.id
    left join users u on ec.created_by = u.id
    where c.id = '$company_id'
    AND ec.name != 'pending'
    union all
    select distinct
    c.id,
    a.id as id,
    at.name as campaign_name,
    con.id as contact_id,
    con.first_name,
    con.last_name,
    a.actioned_at as \"actioned_at\",
    u.image,
    u.name,
    a.created_at,
    a.action_type_id as action_type_id,
    a.actioned_at as actioned_at,
    a.comments
    from actions a
    left join
    action_types at on
    a.action_type_id = at.id
    left join companies c on a.company_id = c.id
    left join users u on a.user_id = u.id
    left join contacts con on a.contact_id = con.id
    where c.id = '$company_id'
    ORDER BY 10 desc";
            $query = $this->db->query($sql);
    return $query->result_object();
    
}

function get_marketing_actions($user_id)
{
    $sql = "select distinct ec.name as campaign, c.id as company_id, c.name as company, c.pipeline, con.first_name, con.last_name, CONCAT(con.last_name, ' ', con.first_name)  as username,to_char(ea.created_at, 'DD-MM-YYYY') as Date, ea.created_at, ea.email_action_type, ea.link as url from companies c
    left join contacts con on
    c.id = con.company_id
    left join email_actions ea on 
    ea.contact_id = con.id
    left join email_campaigns ec on 
    ec.id = ea.email_campaign_id
    where (ea.email_action_type = '2' or ea.email_action_type = '3') and c.pipeline not in ('proposal','customer') and ec.created_by = $user_id
      limit 1 ";
    $query = $this->db->query($sql);
    return $query->result_object();
    
}
    
function get_marketing_actions_two($user_id)
{
    $sql = "select c.id as company_id, to_char(ea.action_time, 'DD-MM-YYYY') as Date,ec.name as campaign, ea.email_action_type as action, c.name as company, c.pipeline, con.first_name, con.last_name, CONCAT(con.last_name, ' ', con.first_name)  as username, ea.created_at, ea.email_action_type, ea.link as url from companies c
    left join contacts con on
    c.id = con.company_id
    left join email_actions ea on 
    ea.contact_id = con.id
    left join email_campaigns ec on 
    ec.id = ea.email_campaign_id
    where (ea.email_action_type = '2' or ea.email_action_type = '3' or ea.email_action_type = '4' or ea.email_action_type = '1' ) and c.pipeline not in ('proposal','customer')  and ec.created_by = $user_id
    AND ec.name IS NOT null
    AND ea.email_action_type !=4
    AND ec.name != 'pending'
    ORDER BY ea.action_time DESC
    limit 200";
    
    //echo $sql;
        //AND ea.created_by = $user_id 
    $query = $this->db->query($sql);
    
    return $query->result_object();
    
}
    
function get_actions_outstanding($company_id)
{
    $category_exclude = array('7', '20');
    $data = array(
        'a.company_id' => $company_id,
        );
    $this->db->select('a.company_id, a.id "action_id",a.comments,a.planned_at,a.action_type_id,u.name ,c.first_name,c.last_name,c.phone,c.email,a.user_id,c.id "contact_id",a.created_at as "created_at",a.actioned_at as "actioned_at",a.planned_at as "planned_at", u.image , comp.name as "company_name", ');
    $this->db->where('a.planned_at IS NOT NULL', null);
    $this->db->where('a.actioned_at IS NULL', null);
    $this->db->where('a.cancelled_at IS NULL', null);
    $this->db->where_not_in('a.action_type_id',$category_exclude);
    $this->db->join('contacts c', 'c.id = a.contact_id', 'left');
    $this->db->join('users u', 'a.user_id = u.id', 'left');
    $this->db->join('companies comp', 'a.company_id = comp.id', 'left');
    $this->db->join('action_types at', 'a.action_type_id = at.id', 'left');


    $this->db->order_by('a.actioned_at desc, a.cancelled_at desc,a.planned_at desc');
    $query = $this->db->get_where('actions a', $data);
    return $query->result_object();
}

function get_actions_completed($company_id)
{
    $category_exclude = array('7', '20');
    $data = array(
        'a.company_id' => $company_id,
        );
    $this->db->select('a.created_at,a.actioned_at,a.action_type_id,a.comments,a.outcome,a.id,u.image,u.name,c.first_name,c.last_name,a.contact_id", ');
    $this->db->join('contacts c', 'c.id = a.contact_id', 'left');
    $this->db->join('users u', 'a.user_id = u.id', 'left');
    $this->db->where('actioned_at IS NOT NULL', null);
    $this->db->where_not_in('action_type_id', $category_exclude);
    $this->db->order_by('actioned_at desc,planned_at desc');
    $query = $this->db->get_where('actions a', $data);
    return $query->result_object();
}

function get_actions_cancelled($company_id)
{
    $category_exclude = array('7', '20');
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where('cancelled_at IS NOT NULL', null);
    $this->db->where_not_in('action_type_id', 7);
    $this->db->order_by('cancelled_at, planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
}

function get_actions_marketing($company_id)
{
    $sql = "select distinct ec.name as campaign_name, con.first_name, con.last_name,  
    c.name, u.email,u.id as user_id,ec.date_sent,ec.sent_id, to_char(ec.date_sent, 'DAY DDth MONTH') as Date,ea.email_action_type as action,
    sum(case when email_action_type = '2' then 1 else 0 end) opened,
    sum(case when email_action_type = '3' then 1 else 0 end) clicked,
    sum(case when email_action_type = '3' and link ilike '%unsubscribe%' then 1 else 0 end) unsubscribed
    from email_campaigns ec
    left join email_actions ea on ec.id = ea.email_campaign_id
    inner join contacts con on ea.contact_id = con.id
    left join companies c on con.company_id = c.id
    left join users u on ec.created_by = u.id
    where c.id = '$company_id'
    AND ec.name != 'pending'
    group by 1,2,3,4,5,6,7,8,ea.email_action_type order by date_sent asc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}

function get_comments($company_id)
{
    $data = array(
        'company_id' => $company_id,
        );
    $this->db->where('action_type_id', '7');
    $this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
    $query = $this->db->get_where('actions', $data);
    return $query->result_object();
}

function get_pending_actions($user_id)
{		
    $this->db->select("actions.company_id, actions.id as action_id,comments,planned_at,action_type_id,name as company_name,contacts.first_name,contacts.last_name,contacts.phone,contacts.email, to_char(planned_at, 'HH24:MI DD/MM/YY') as duedate ");
    $this->db->where('actions.user_id',$user_id);
    $this->db->where('actioned_at',NULL);
    $this->db->where('cancelled_at',NULL);
    $this->db->join('companies', 'companies.id = actions.company_id', 'left');
    $this->db->join('contacts', 'contacts.id = actions.contact_id', 'left');
    $this->db->order_by('cancelled_at desc,planned_at asc');
    $query = $this->db->get('actions');
    // var_dump($query);
    return $query->result_object();

}
function get_assigned_companies($user_id)
{	
    
    $this->db->where('user_id',$user_id);
    $this->db->where('active','t');
    $this->db->order_by("assign_date", "desc"); 
    $query = $this->db->get('companies');
    return $query->result_object();

}
function get_recent_stats($period, $team_type)
{   
    if(!empty($team_type)){
        $team_type_sql = "and u.market = '$team_type'";
    }
    $dates = $this->dates($period);
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    $sql = "select U.name, U.id as user, U.image, U.active as active,
    sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
    sum(case when (action_type_id = '4' or action_type_id = '5' or action_type_id = '11' or action_type_id = '17')  AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) salescall,
    sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
    sum(case when (action_type_id = '12' or action_type_id = '10') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
    sum(case when (action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) democount,
    sum(case when (action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) demobookedcount,
    sum(case when (action_type_id = '12' or action_type_id = '10') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
    sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
    sum(case when action_type_id = '25' AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) duediligence,
    sum(case when action_type_id = '22' AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) key_review_added,
    sum(case when action_type_id = '22' AND a.planned_at > '$start_date' AND a.planned_at < '$end_date' then 1 else 0 end) key_review_occuring,
    sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals,
    Sum(case when action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' THEN 1 ELSE 0 END) AS pipelinecount
    from actions A INNER JOIN companies C on A.company_id = C.id INNER JOIN users U on A.user_id = U.id group by U.id,U.name,a.cancelled_at, u.department HAVING cancelled_at is null and u.department = 'sales' and (u.active = 't' or sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) >0) $team_type_sql order by deals desc,proposals desc,meetingbooked desc, introcall desc, name desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}

function get_pipeline_contacted()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }else{
        $start_date_sql = "a.created_at > NOW() - INTERVAL '30 days'";}
        $sql = "select
        c.id as company_id,
        a.comments,
        c.name as company_name,
        a.id,
        a.created_at,
        c.pipeline,
        u.name as username
        from companies c
        inner join actions a on
        c.id = a.company_id
        and a.id = 	(
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' and c.pipeline not in ('Customer','customer','Proposal','proposal','Lost','lost')
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
    
function get_pipeline_contacted_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '30 days'";}
        $sql = "select
        c.id as company_id,
        a.comments,
        c.name as company_name,
        a.id,
        a.created_at,
        c.pipeline,
        u.name as username
        from companies c
        inner join actions a on
        c.id = a.company_id
        and a.id = 	(
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' 
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19'  and c.pipeline not in ('Customer','customer','Proposal','proposal','Lost','lost') and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_proposal()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '60 days'";
    }
    $sql = "select
    c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id = 	(
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and a.created_at > NOW() - INTERVAL '60 days' AND $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_proposal_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($_GET['start_date'])) {
        $start_date_sql = "a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
    }
    else {
        $start_date_sql = "a.created_at > NOW() - INTERVAL '60 days'";}
        $sql = "select
        c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id = 	(
        SELECT MAX(id) 
        FROM actions z 
        WHERE z.company_id = a.company_id and z.action_type_id = '19' 
        order by a.actioned_at desc
        ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and $start_date_sql order by a.created_at desc";
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_customer()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($start_date)) {
        $start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
    }
    $sql = "select c.id as company_id, a.comments, c.name as company_name, a.id, a.created_at, c.pipeline, u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id = 	(
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '16' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '16'   $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_customer_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (isset($start_date)) {
    $start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
    }
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id = 	(
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '16' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '16' and (c.pipeline ilike '%customer%') $start_date_sql order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_lost()
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id = 	(
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' and a.created_at > NOW() - INTERVAL '60 days' order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_pipeline_lost_individual($user_id)
{
    $dates = $this->dates();
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    $sql = "select
    c.id as company_id,
    a.comments,
    c.name as company_name,
    a.id,
    a.created_at,
    c.pipeline,
    u.name as username
    from companies c
    inner join actions a on
    c.id = a.company_id
    and a.id = 	(
    SELECT MAX(id) 
    FROM actions z 
    WHERE z.company_id = a.company_id and z.action_type_id = '19' 
    order by a.actioned_at desc
    ) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date'order by a.created_at desc";
    $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
function get_user_placements($period)
{
    $dates = $this->dates($period);
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    $search_user_id = $dates['search_user_id'];
    if (!empty($search_user_id)) {
        $sql = "select distinct c.name, a.actioned_at, c.id, a.created_by, c.id as compid, u.name as username, ls.name as lead_name, c.initial_rate from companies c 
         inner join actions a on c.id = a.company_id
         left join lead_sources ls on c.lead_source_id = ls.id
         left join users u on a.created_by = u.id where a.action_type_id = '16' and a.user_id = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.actioned_at asc";
        
        //echo $sql;
        $query = $this->db->query($sql);
    if($query){
        return $query->result_array();
    }else{
        return [];
    }
}
}

function dates($period)
{
    if ($period==='search') {
        if (!empty($_GET['start_date'])) {
            $start_date = date('Y-m-d 00:00:00',strtotime($_GET['start_date']));
        } else {
            $start_date = date('Y-m-d 23:59:59',strtotime('first day of this month'));
        }
        if (!empty($_GET['end_date'])) {
            $end_date = date('Y-m-d 23:59:59',strtotime($_GET['end_date']));
        } else {
            $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
        }
    }
    else if ($period==='week') {
        $start_date = date('Y-m-d 00:00:00',strtotime('monday this week'));
        $end_date = date('Y-m-d 23:59:59',strtotime('sunday this week'));
    }
    else if ($period==='lastweek') {
        $start_date = date('Y-m-d 00:00:00',strtotime('monday last week'));
        $end_date = date('Y-m-d 23:59:59',strtotime('sunday last week'));
    }
    else if ($period==='thismonth') {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
    }
    else if ($period==='lastmonth') {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of previous month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of previous month'));
    }
    else
    {
        $start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
        $end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
    }
        return array('search_user_id' => $_GET['user'], 'start_date' => $start_date, 'end_date' => $end_date);
}


function get_user_proposals($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = date('Y-m-d H:i:s', strtotime($dates['end_date'] . ' +1 day'));
    if (!empty($search_user_id)) {
        $sql = "select distinct c.name, a.created_at, c.id from companies c inner join actions a on c.id = a.company_id where a.action_type_id = '8' and a.user_id = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.created_at asc";
        $query = $this->db->query($sql);
        if($query){
            return $query->result_array();
        }else{
            return [];
        }
    }
}


function get_user_meetings($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    if (!empty($search_user_id)) {
         $sql = "select distinct c.name, a.created_at,a.actioned_at,a.planned_at, c.id from companies c inner join actions a on c.id = a.company_id where (action_type_id = '12' or action_type_id = '10') and a.user_id = '$search_user_id' AND (a.created_at > '$start_date' or a.actioned_at > '$start_date') AND (a.created_at < '$end_date' or a.actioned_at < '$end_date') group by c.name, a.created_at,a.actioned_at,a.planned_at, c.id order by a.actioned_at, a.planned_at asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}

function get_user_demos($period)
{
    $dates = $this->dates($period);
    $search_user_id = $dates['search_user_id'];
    $start_date = $dates['start_date'];
    $end_date = $dates['end_date'];
    if (!empty($search_user_id)) {

      $sql = "select distinct c.name, a.created_at,a.actioned_at,a.planned_at, c.id from companies c inner join actions a on c.id = a.company_id where (action_type_id = '9' or action_type_id = '15') and (a.created_by = '$search_user_id' or a.updated_by = '$search_user_id') AND (a.created_at > '$start_date' or a.actioned_at > '$start_date') AND (a.created_at < '$end_date' or a.actioned_at < '$end_date') and a.cancelled_at is null group by c.name, a.created_at,a.actioned_at,a.planned_at, c.id order by a.actioned_at, a.planned_at asc";
    $query = $this->db->query($sql);
    return $query->result_array();
}
}


function get_action_types_array()
{
    $this->db->select("id,name");
    $query = $this->db->get('action_types');
    foreach($query->result() as $row)
    {
      $array[$row->id] = $row->name;
    } 	
    return $array;

}

function get_action_types_done()
{
    $ignore = array('19','7','20'); //EXCLUDE PIPELINE TRACKING, COMMENT AND MARKETING//
    $data = array(
        'type' => 'Done',
        );
    $this->db->where_not_in('id', $ignore);
    $this->db->order_by('name', 'asc'); 

    $query = $this->db->get_where('action_types',$data);
    return $query->result_object();
}


function get_action_types_planned()
{	
    $this->db->order_by('name', 'asc'); 
    $query = $this->db->get_where('action_types',array('type'=>'Planned'));
    return $query->result_object();
}

// UPDATES
function set_action_state($action_id,$user_id,$state,$outcome)

{
    if($state == 'completed'){
        $data = array(
        'outcome' => (!empty($outcome)?$outcome:NULL),
        'actioned_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user_id,
        );
    }
    
    if($state == 'cancelled'){
        $data = array(
        'outcome' => (!empty($outcome)?$outcome:NULL),
        'cancelled_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user_id,
        );
    }
    
    $this->db->where('id',$action_id);
    $this->db->update('actions',$data);
    if($this->db->affected_rows() !== 1){
        $this->addError($this->db->_error_message());
        return False;
    }else{
        return True;
    } 
    
}

// INSERTS
function create($post)
{
    if ($post['action_type_completed']>0) {

    //TEST - COMPLETED ACTION ONLY
    $completeddata = array(
        'company_id' 	=> $post['company_id'],
        'user_id' 		=> $post['user_id'],
        'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
        'planned_at'	=> NULL,
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'	=> $post['user_id'],
        'action_type_id'=> (isset($post['action_type_completed'])?$post['action_type_completed']:$post['action_type']),
        'actioned_at'	=> date('Y-m-d H:i:s'),
        'created_at' 	=> date('Y-m-d H:i:s'),
        );
    $query = $this->db->insert('actions', $completeddata);
    //END TEST
    }
    
    if ($post['action_type_planned']>0) {

        $planneddata = array(
        'company_id' 	=> $post['company_id'],
        'user_id' 		=> $post['user_id'],
        'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
        'planned_at'	=> $post['planned_at'],
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'	=> $post['user_id'],
        'action_type_id'=> $post['action_type_planned'],
        'actioned_at'	=> NULL,
        'created_at' 	=> date('Y-m-d H:i:s'),
        );
        $query = $this->db->insert('actions', $planneddata);

    }
    return $this->db->insert_id();    
}

function company_updated_to_customer($post){
 
    if(isset($post['initialfee']) && is_numeric($post['initialfee'])){
        $data = array(
        'initial_rate'  => (!empty($post['initialfee'])? $this->calIntRate($post['initialfee']):NULL)
            );
        $this->db->where('id', $post['company_id']);
        $this->db->update('companies', $data); 
        
    }
    $actiondata = array(
                'company_id' 	=> $post['company_id'],
                'user_id' 		=> $post['user_id'],
                'comments'		=> 'Pipeline changed to Customer',
                'planned_at'	=> (!empty($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
                'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
                'created_by'	=> $post['user_id'],
                'action_type_id'=> '19',
                'actioned_at'	=> date('Y-m-d H:i:s'),
                'created_at' 	=> date('Y-m-d H:i:s'),
                );
    $query = $this->db->insert('actions', $actiondata);
    return $this->db->insert_id();
    
}

function company_updated_to_proposal($post)
{
    $actiondata = array(
        'company_id' 	=> $post['company_id'],
        'user_id' 		=> $post['user_id'],
        'comments'		=> 'Pipeline changed to Proposal',
        'planned_at'	=> (!empty($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
        'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
        'created_by'	=> $post['user_id'],
        'action_type_id'=> '19',
        'actioned_at'	=> date('Y-m-d H:i:s'),
        'created_at' 	=> date('Y-m-d H:i:s'),
        );

    $query = $this->db->insert('actions', $actiondata);
    return $this->db->insert_id();

}
    
function add_to_zendesk($post)
{
		$company_id = $post['company_id'];
		$this->db->where('id', $company_id);
		$this->db->limit(1);
		$query = $this->db->get('companies');
    foreach ($query->result() as $row){
      $company_name= $row->name;
      $company_url= str_replace("http://"," ",str_replace("www.", "", $row->url));
    }
    $ch = curl_init();
    $username = 'dchapple@sonovate.com';
    $password = '25Million';
    curl_setopt($ch, CURLOPT_URL, "https://sonovate.zendesk.com/api/v2/organizations.json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $body = '{"organization": {"name": "'.$company_name.'","domain_names": ["'.$company_url.'"]}}';

    curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Connection: Keep-Alive'
    ));
    $result=curl_exec($ch);
    $data = json_decode($result, true);
    $zendesk_id = $data["organization"]["id"]; // "John"
    if(!empty($zendesk_id)) {
        $data = array('zendesk_id' => $zendesk_id);
        $this->db->where('id', $company_id);
        $this->db->update('companies', $data); 
    }
    curl_close($ch);

}	
	// DELETES
function delete_campaign($id,$user_id)
{
    $data = array(
        'eff_to' => date('Y-m-d'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $user_id,
    );
    $this->db->where('id',$id);
    $this->db->update('campaigns',$data);
    if($this->db->affected_rows() !== 1){
        $this->addError($this->db->_error_message());
        return False;
    }else{
        return True;
    } 
}
    
  function calIntRate($number){
  
    if($number < 5 && strpos($number,".") != true ){ //if single digit less than 5 then acc
        $number  =  str_pad($number, 4, ".00", STR_PAD_RIGHT);
    }elseif($number < 5 && strpos($number,".") == true){
        $number =  str_pad($number, 4, "00", STR_PAD_RIGHT);
       
    }elseif(!strpos($number,".")){
        $number =  $number /100;
        $number =  str_pad($number, 3, "0", STR_PAD_LEFT);
        
         //echo $number;
    }else{


    } 
    
   return  $number;
    }

}
