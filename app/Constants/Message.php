<?php
namespace App\Constants;
final class Message
{
    const SUCCESS = "Success";
    const ERROR = "ERROR";
    const SERVER_ERROR = "Server error";

    // Project's messages
    const PROJECT_DELETE_FAIL = "Delete project fail";
    //Plant
    const DELETE_PLANT_FAIL = 'Delete plant fail';
    // Plant Profile messages
    const OPERATOR_DELETE_FAIL = "Delete operator fail";
    const ELECTRICIAN_DELETE_FAIL = "Delete electrician fail";
    const MECHANIC_DELETE_FAIL = "Delete mechanic fail";
    const RISK_ASSESSOR_DELETE_FAIL = "Delete risk assessor fail";
    const PROJECT_REMOVE_FAIL = "Remove project fail";
    const PROJECT_SAVE_FAIL = "Save project fail";
    const PLANT_OWNER_SAVE_FAIL = "Save plant owner fail";
    const PLANT_PROFILE_SAVE_FAIL = "Save plant profile fail";
    // Request Project
    const FAIL_APPROVED = "Approved Fail";
    const FAIL_CANCEL = "Canceled Fail";
    const FAIL_REJECT = "Rejected Fail";
    const IS_APPROVED = "Is Approved";
    const IS_REJECTED = "Is Rejected";
    const IS_CANCEL = "Is Canceled";
    const PLANT_EXISTS_PROJECT="Plant already exists in a project";
    //defect
    const DELETE_DEFECT_FAIL = 'Delete defect fail';
}