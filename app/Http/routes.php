<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/admin', 'AdminController@index');
Route::post('/adminLogin', 'AdminController@adminLogin');
Route::get('/profile', 'AdminController@profile');
Route::get('/updateProfile/{id}', 'AdminController@updateProfile');
Route::get('/changePassword', 'AdminController@changePassword');
Route::post('/updatePassword', 'AdminController@updatePassword');
Route::get('/adminLogout', 'AdminController@adminLogout');

#-------------------- Insitute Info -----------------------------#
Route::get('/instituteProfile', 'AdminController@instituteProfile');
Route::get('/instituteProfileInfo/{id}', 'AdminController@instituteProfileInfo');
Route::post('/updateInstituteProfileInfo', 'AdminController@updateInstituteProfileInfo');
Route::get('/instituteChangePassword', 'AdminController@instituteChangePassword');
Route::post('/instituteUpdatePassword', 'AdminController@instituteUpdatePassword');

Route::get('/adminDashboard', 'DashboardController@adminDashboard');
Route::get('/instituteDashboard', 'DashboardController@instituteDashboard');
Route::get('/userDashboard', 'DashboardController@userDashboard');
Route::get('/organizationDashboard', 'DashboardController@organizationDashboard');
Route::get('/kaziDashboard', 'DashboardController@kaziDashboard');
Route::get('/udcDashboard', 'DashboardController@udcDashboard');

#-------------------- User Add Section ----------------------#
Route::get('/addUser', 'AdminController@addUser');
Route::post('/addUserInfo', 'AdminController@addUserInfo');
Route::get('/manageUser', 'AdminController@manageUser');
Route::get('/changeUserStatus/{id}', 'AdminController@changeUserStatus');
Route::get('/editUser/{id}', 'AdminController@editUser');
Route::post('/updateUserInfo', 'AdminController@updateUserInfo');

#-------------------- UDC Section ----------------------#
Route::get('/udcProfile', 'UdcController@udcProfile');
Route::get('/udcProfileInfo', 'UdcController@udcProfileInfo');
Route::post('/updateUdcProfileInfo', 'UdcController@updateUdcProfileInfo');
Route::get('/udcChangePassword', 'UdcController@udcChangePassword');
Route::post('/udcUpdatePasswordInfo', 'UdcController@udcUpdatePasswordInfo');


#------------------ User Sign UP -----------------------#
Route::get('/signUp', 'RegistrationController@signUp');
Route::post('/userSignUpInfo', 'RegistrationController@userSignUpInfo');
Route::get('/pendingUserList', 'RegistrationController@pendingUserList');
Route::get('/userStatusApprove/{id}', 'RegistrationController@userStatusApprove');
Route::get('/userStatusReject/{id}', 'RegistrationController@userStatusReject');
Route::get('/rejectUserList/', 'RegistrationController@rejectUserList');
Route::get('/activeUserList/', 'RegistrationController@activeUserList');
Route::get('/editActiveUser/{id}', 'RegistrationController@editActiveUser');
Route::post('/updateActiveUserInfo', 'RegistrationController@updateActiveUserInfo');

#------------------- User Add -------------------------------#
Route::get('/addAppUser', 'RegistrationController@addAppUser');
Route::post('/addAppUserInfo', 'RegistrationController@addAppUserInfo');


#------------------- Designation ---------------------------#
Route::get('/addDesignation', 'CommitteeController@addDesignation');
Route::post('/addDesignationInfo', 'CommitteeController@addDesignationInfo');
Route::get('/manageDesignation', 'CommitteeController@manageDesignation');
Route::get('/changeDesignationStatus/{id}', 'CommitteeController@changeDesignationStatus');
Route::get('/editDesignation/{id}', 'CommitteeController@editDesignation');
Route::post('/updateDesignationInfo', 'CommitteeController@updateDesignationInfo');

#------------------- Union ---------------------------------#
Route::get('/addUnion', 'CommitteeController@addUnion');
Route::post('/addUnionInfo', 'CommitteeController@addUnionInfo');
Route::get('/manageUnion', 'CommitteeController@manageUnion');
Route::get('/changeUnionStatus/{id}', 'CommitteeController@changeUnionStatus');
Route::get('/editUnion/{id}', 'CommitteeController@editUnion');
Route::post('/updateUnionInfo', 'CommitteeController@updateUnionInfo');

#-------------------- Ward ----------------------------------#
Route::get('/addWard', 'WardController@addWard');
Route::post('/addWardInfo', 'WardController@addWardInfo');
Route::get('/manageWard', 'WardController@manageWard');
Route::get('/editWard/{id}', 'WardController@editWard');
Route::post('/updateWardInfo', 'WardController@updateWardInfo');

#----------------- Institute -------------------------------#
Route::get('/addInstitute', 'InstituteController@addInstitute');
Route::post('/getWardByUnion', 'InstituteController@getWardByUnion');
Route::post('/getWardByUnionForFront', 'InstituteController@getWardByUnionForFront');
Route::post('/addInstituteInfo', 'InstituteController@addInstituteInfo');
Route::get('/manageInstitute', 'InstituteController@manageInstitute');
Route::get('/editInstitute/{id}', 'InstituteController@editInstitute');

#---------------- Health Organization ---------------------#
Route::get('/addHealthOrganization', 'HealthController@addHealthOrganization');
Route::post('/addHealthOgranizationInfo', 'HealthController@addHealthOgranizationInfo');
Route::get('/manageHealthOrganization', 'HealthController@manageHealthOrganization');
Route::get('/organizationProfile', 'HealthController@organizationProfile');
Route::get('/organizationProfileInfo', 'HealthController@organizationProfileInfo');
Route::post('/updateOrganizationProfileInfo', 'HealthController@updateOrganizationProfileInfo');
Route::get('/organizationChangePassword', 'HealthController@organizationChangePassword');
Route::post('/organizationUpdatePasswordInfo', 'HealthController@organizationUpdatePasswordInfo');

#------------------- Commitee member -----------------------#
Route::get('/addCommitteeMember', 'CommitteeController@addCommitteeMember');
Route::post('/addCommitteeMemberInfo', 'CommitteeController@addCommitteeMemberInfo');
Route::get('/manageCommitteeMember', 'CommitteeController@manageCommitteeMember');
Route::get('/editCommitteeMember/{id}', 'CommitteeController@editCommitteeMember');
Route::post('/updateCommitteeMemberInfo', 'CommitteeController@updateCommitteeMemberInfo');
Route::get('/changeMemberStatus/{id}', 'CommitteeController@changeMemberStatus');
Route::get('/unionWiseCommitteeMember', 'CommitteeController@unionWiseCommitteeMember');
Route::post('/getCommitteeWiseMemberList', 'CommitteeController@getCommitteeWiseMemberList');
Route::get('/addUpazilaCommitteeMember', 'CommitteeController@addUpazilaCommitteeMember');
Route::post('/addUpazilaCommitteeMemberInfo', 'CommitteeController@addUpazilaCommitteeMemberInfo');
Route::get('/manageUpazilaCommitteeMember', 'CommitteeController@manageUpazilaCommitteeMember');
Route::get('/editUpazilaCommitteeMember/{id}', 'CommitteeController@editUpazilaCommitteeMember');
Route::post('/updateUpazilaCommitteeMemberInfo', 'CommitteeController@updateUpazilaCommitteeMemberInfo');
Route::get('/changeUpazilaMemberStatus/{id}', 'CommitteeController@changeUpazilaMemberStatus');

#------------------ SMS -------------------------------------#
Route::get('/sendSms', 'SmsController@sendSms');
Route::post('/smsSendingInfo', 'SmsController@smsSendingInfo');
Route::get('/manageSendSmsHistory', 'SmsController@manageSendSmsHistory');

#----------------- Candiate SMS Send -----------------------#
Route::get('/candidatesSmsSend', 'SmsController@candidatesSmsSend');
Route::post('/getCanidateBySearchValue', 'SmsController@getCanidateBySearchValue');
Route::post('/sendSMSbyAdminSearch', 'SmsController@sendSMSbyAdminSearch');
Route::get('/userSmsSend', 'SmsController@userSmsSend');
Route::post('/sendSMSbyAdminAppUser', 'SmsController@sendSMSbyAdminAppUser');
Route::get('/childSmsSend', 'SmsController@childSmsSend');
Route::post('/sendSmsByAdminForChild', 'SmsController@sendSmsByAdminForChild');
Route::get('/instituteSmsSend', 'SmsController@instituteSmsSend');
Route::post('/sendSMSbyAdminInstitute', 'SmsController@sendSMSbyAdminInstitute');
Route::get('/organizationSmsSend', 'SmsController@organizationSmsSend');
Route::post('/sendSMSbyAdminOrganization', 'SmsController@sendSMSbyAdminOrganization');

Route::get('/sendSMSByUDC', 'SmsController@sendSMSByUDC');
Route::post('/sendSMSByUDCForCandidates', 'SmsController@sendSMSByUDCForCandidates');

#------------------- Candidate Controller ---------------------#
Route::get('/addStudent', 'CandidateController@addStudent');
Route::post('/addStudentInfo', 'CandidateController@addStudentInfo');
Route::get('/manageStudent', 'CandidateController@manageStudent');
Route::get('/viewStudentInfo/{id}', 'CandidateController@viewStudentInfo');

#------------------- Child Section ----------------------------#
Route::get('/addChild', 'CandidateController@addChild');
Route::post('/addChildInfo', 'CandidateController@addChildInfo');
Route::get('/manageChild', 'CandidateController@manageChild');
Route::get('/viewChildInfo/{id}', 'CandidateController@viewChildInfo');
Route::get('/searchCandidates', 'CandidateController@searchCandidates');
Route::post('/candidateSearchResultView', 'CandidateController@candidateSearchResultView');
Route::get('/adminCandidateSearch', 'CandidateController@adminCandidateSearch');
Route::post('/adminCadidateSearchResultView', 'CandidateController@adminCadidateSearchResultView');

#------------------------- Organization -----------------------------#
Route::get('/studentAddForm', 'CandidateController@studentAddForm');
Route::post('/getUnionWiseSchool', 'InstituteController@getUnionWiseSchool');
Route::get('/manageAllStudent', 'CandidateController@manageAllStudent');
Route::get('/instituteSearchCandidates', 'CandidateController@instituteSearchCandidates');

Route::get('/adminManageCandidates', 'CandidateController@adminManageCandidates');
Route::get('/viewCandidatesInfo/{id}', 'CandidateController@viewCandidatesInfo');
Route::get('/editCandidatesInfo/{id}', 'CandidateController@editCandidatesInfo');
Route::post('/updateCandidatesInfo', 'CandidateController@updateCandidatesInfo');
Route::get('/manageCandidatesByKazi', 'CandidateController@manageCandidatesByKazi');
Route::get('/updateCandidateStatusByKazi/{id}', 'CandidateController@updateCandidateStatusByKazi');
Route::post('/updateCandidatesMarriageDateInfo', 'CandidateController@updateCandidatesMarriageDateInfo');

Route::get('/addOrgStudent', 'CandidateController@addOrgStudent');
Route::post('/insertSutdentInfoByOrganization', 'CandidateController@insertSutdentInfoByOrganization');
Route::get('/manageCandiatesByOrganization', 'CandidateController@manageCandiatesByOrganization');
Route::get('/editCandidatesByOrganization/{id}', 'CandidateController@editCandidatesByOrganization');
Route::post('/updateCandidatesByOrganization', 'CandidateController@updateCandidatesByOrganization');
Route::get('/viewOrgStudentInfo/{id}', 'CandidateController@viewOrgStudentInfo');

Route::get('/addOrgChild', 'CandidateController@addOrgChild');
Route::post('/insertChildInfoByOrganization', 'CandidateController@insertChildInfoByOrganization');
Route::get('/manageInstituteCandidates', 'CandidateController@manageInstituteCandidates');
Route::get('/editInstituteCandidates/{id}', 'CandidateController@editInstituteCandidates');
Route::post('/updateInstituteCandidates', 'CandidateController@updateInstituteCandidates');


#----------------------- Admin Candidate ADD Section ---------------------#
Route::get('/adminAddStudent', 'CandidateController@adminAddStudent');
Route::post('/insertStudentInfoByAdmin', 'CandidateController@insertStudentInfoByAdmin');
Route::get('/adminAddChild', 'CandidateController@adminAddChild');
Route::post('/insertChildInfoByAdmin', 'CandidateController@insertChildInfoByAdmin');
Route::get('/adminNewCandidates', 'CandidateController@adminNewCandidates');


#==================== UDC Candiates Section =======================#
Route::get('/searchCandidatesByUdc', 'CandidateController@searchCandidatesByUdc');
Route::get('/updateCandiateBirthReg/{id}', 'CandidateController@updateCandiateBirthReg');
Route::post('/updateCandidateBirthRegNumber', 'CandidateController@updateCandidateBirthRegNumber');
Route::get('/addCandidatesByUdc', 'CandidateController@addCandidatesByUdc');
Route::post('/insertCandidateInfoByUDC', 'CandidateController@insertCandidateInfoByUDC');
Route::get('/candidateBirthRegDustributionComplete/{id}', 'CandidateController@candidateBirthRegDustributionComplete');
Route::get('editCandidatesByUdc/{id}','CandidateController@editCandidatesByUdc');
Route::post('updateCandidatesByUdc','CandidateController@updateCandidatesByUdc');
Route::get('newCandidateListByUdc','CandidateController@newCandidateListByUdc');
Route::get('viewNewCandidatesByUdc/{id}','CandidateController@viewNewCandidatesByUdc');

#----------------------- Kazi Section ------------------------------#
Route::get('/addKazi', 'KaziController@addKazi');
Route::post('/addKaziInfo', 'KaziController@addKaziInfo');
Route::get('/manageKazi', 'KaziController@manageKazi');
Route::get('/editKaziInfo/{id}', 'KaziController@editKaziInfo');
Route::get('/kaziProfile', 'KaziController@kaziProfile');
Route::get('/updateKaziProfile/{id}', 'KaziController@updateKaziProfile');
Route::post('/updateKaziProfileInfo', 'KaziController@updateKaziProfileInfo');
Route::get('/kaziChangePassword', 'KaziController@kaziChangePassword');
Route::post('/kaziUpdatePassword', 'KaziController@kaziUpdatePassword');

#--------------------- Settings --------------------------------#
Route::get('/ageSettings', 'SettingsController@ageSettings');
Route::post('/updateAgeSettings', 'SettingsController@updateAgeSettings');

#------------------- Print Controller --------------------------#
Route::post('/printAdminCandidateSearchResultView', 'PrintController@printAdminCandidateSearchResultView');
Route::post('/printNewCandidateListByUdc','PrintController@printNewCandidateListByUdc');
Route::post('/printNewCandidateListByAdmin','PrintController@printNewCandidateListByAdmin');

#----------------- CSV Controller -----------------------#
Route::post('/exportCandidateSearchResult', 'CsvController@exportCandidateSearchResult');

#--------------------- Fron End --------------------------------#
Route::get('/', 'FrontController@index');
Route::get('/unoSpeech', 'FrontController@unoSpeech');
Route::get('/checkAge', 'FrontController@checkAge');
Route::post('/getFontCheckAgeDataView', 'FrontController@getFontCheckAgeDataView');
Route::get('/application', 'FrontController@application');
Route::post('/sendMessageByUser', 'FrontController@sendMessageByUser');
Route::get('/childMarriageLow', 'FrontController@childMarriageLow');
Route::post('/visitorCount', 'FrontController@visitorCount');

#-----------------------Start of Unit----------------------------#
Route::get('/addUnit', 'UnitController@addUnit');
Route::post('/addUnitInfo', 'UnitController@addUnitInfo');
Route::get('/manageUnit', 'UnitController@manageUnit');
Route::get('/editUnit/{id}', 'UnitController@editUnit');
Route::post('/updateUnitInfo', 'UnitController@updateUnitInfo');
#-----------------------End of Unit------------------------------#

#------------------------ Start of Founder ----------------------#
Route::get('/founderInfo','CandidateController@founderInfo');
Route::post('/updateFounderInfo','CandidateController@updateFounderInfo');
#------------------------ Start of Founder ----------------------#

