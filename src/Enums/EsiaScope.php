<?php
namespace Pavelrockjob\Esia\Enums;

enum EsiaScope {
    case fullname;
    case openid;
    case email;
    case snils;
    case inn;
    case id_doc;
    case birthplace;
    case medical_doc;
    case military_doc;
    case foreign_passport_doc;
    case drivers_licence_doc;
    case birth_cert_doc;
    case residence_doc;
    case temporary_residence_doc;
    case vehicles;
    case mobile;
    case addresses;
    case usr_org;
    case usr_avt;
    case self_employed;
    case kid_fullname;
    case kid_birthdate;
    case kid_gender;
    case kid_snils;
    case kid_inn;
    case kid_birth_cert_doc;
    case kid_medical_doc;

    case org_shortname;
    case org_fullname;
    case org_type;
    case org_ogrn;
    case org_inn;
    case org_leg;
    case org_kpp;
    case org_agencyterrange;
    case org_agencytype;
    case org_oktmo;
    case org_ctts;
    case org_addrs;
    case org_vhls;
    case org_grps;
    case org_emps;
    case org_brhs;
    case org_brhs_ctts;
    case org_brhs_addrs;
    case org_rcs;
    case org_stms;
    case org_invts;
    case categories;
}
