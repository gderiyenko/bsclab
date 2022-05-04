<template>
    <span>
        <b-button variant="outline-secondary" v-b-modal.modal-xl>Легенда</b-button>

        <b-modal id="modal-xl" size="xl" centered title="Легенда до шаблонів"
                 :header-bg-variant="headerBgVariant" :hide-footer="true">

        <div class="row">
            <div class="col-md-12">

                <h5 class="mb-3"><strong>Найменування контрагента</strong></h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <label>Повна назва</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='firm_name' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="firm_name"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Скорочена назва</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='firm_name_short' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="firm_name_short"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Код ЄДРПОУ</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='edrpou' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="edrpou"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ІПН</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='ipn' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="ipn"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Оподаткування</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='tax' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="tax"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Керівництво</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Посада керівника</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='boss_position' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="boss_position"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ПІБ керівника (повністю)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='boss_pib' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="boss_pib"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ПІБ керівника (скорочено)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='boss_pib_short' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="boss_pib_short"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Посада відповідального за роботи</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='work_position' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="work_position"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ПІБ відповідального за роботи (повністю)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='work_pib' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="work_pib"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ПІБ відповідального за роботи (скорочено)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='work_pib_short' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="work_pib_short"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Юридична адреса</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Індекс</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_zip_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_zip_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Область</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_obl_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_obl_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Місто (селище, село)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_city_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_city_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Вулиця</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_street_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_street_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Будинок</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_house_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_house_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Офіс (приміщення)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_office_ur' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_office_ur"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Фактична адреса</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Індекс</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_zip_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_zip_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Область</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_obl_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_obl_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Місто (селище, село)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_city_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_city_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Вулиця</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_street_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_street_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Будинок</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_house_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_house_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Офіс (приміщення)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='addr_office_fact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="addr_office_fact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Реквізити банківського рахунку</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Назва банку</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='bank_name' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="bank_name"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Номер рахунку</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='account_number' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="account_number"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>МФО банку</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='bank_mfo' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="bank_mfo"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Контактні дані</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Телефон загальний</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='phone_shared' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="phone_shared"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Телефон бухгалтера</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='phone_acc' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="phone_acc"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Телефон відповідального за роботи</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='phone_work' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="phone_work"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email загальний</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='email_shared' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="email_shared"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email бухгалтера</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='email_acc' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="email_acc"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Email відповідального за роботи</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='email_work' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="email_work"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Перевізник</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Назва</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='carr_name' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="carr_name"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Місто</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='carr_city' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="carr_city"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Відділення</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='carr_dep' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="carr_dep"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>ПІБ отримувача</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='carr_pib' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="carr_pib"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Телефон отримувача</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='carr_phone' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="carr_phone"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Договір</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Номер</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='contract_number' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="contract_number"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата договору (цифрами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='contract_date_cyf' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="contract_date_cyf"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата довору (словами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='contract_date' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="contract_date"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата припинення</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='contract_date_end' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="contract_date_end"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Рахунок</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Номер</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_number' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_number"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата (цифрами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_date_cyf' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_date_cyf"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата (словами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_date' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_date"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Акт</strong></h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Номер</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='act_number' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="act_number"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата (цифрами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='act_date_cyf' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="act_date_cyf"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Дата (словами)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='act_date' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="act_date"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                <hr>
                <h5 class="mb-3"><strong>Послуги та вартість</strong>&nbsp;(дивись примітку)</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Назва матеріалу (1,2,3...)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_material' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_material"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Характеристика матеріалу (1,2,3...)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_charact' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_charact"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Кількість поточної послуги (1,2,3...)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_quantity' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_quantity"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Ціна з ПДВ за поточну послугу (1,2,3...)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_price' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_price"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Сумма з ПДВ за поточну послугу (1,2,3...)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_amount' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_amount"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label>Загальна вартість по рахунку (акту) з ПДВ</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='amount' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="amount"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Загальна вартість по рахунку (акту) з ПДВ текстом</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='amount_text' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="amount_text"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Загальна вартість по рахунку (акту) без ПДВ текстом</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='pdv_minus_text' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="pdv_minus_text"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Загальний ПДВ рахунку (акту)</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='amount_pdv' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="amount_pdv"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                         <div class="col-md-4 mb-3">
                            <label>Загальний ПДВ рахунку (акту) текстом</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='amount_pdv_text' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="amount_pdv_text"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Загальна кількість найменувань</label>
                            <b-input-group class="mb-3">
                                <b-form-input v-model='inv_count' readonly></b-form-input>
                                <b-input-group-append>
                                    <b-button variant="outline-success"
                                              type="button"
                                              :title="'Копіювати'"
                                              v-clipboard:copy="inv_count"
                                              v-clipboard:success="onCopy"
                                              v-clipboard:error="onError">
                                        <fa-layer class="fa-1x">
                                            <fa-icon :icon="['fas', 'copy']" style="color:Grey"/>
                                        </fa-layer>
                                    </b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </div>
                        <div class="col-md-12 mb-12">
                            <strong>Примітка:</strong>&nbsp;(1,2,3...) - мається на увазі те, що в шаблоні в таблиці рахунку (акта) для,
                            наприклад, другої послуги слід вставляти наступні значення: ${inv_material_2}, ${inv_charact_2},
                            ${inv_quantity_2}, ${inv_price_2}, ${inv_amount_2}
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </b-modal>

    </span>

</template>

<script>
export default {
    name: "Legend",
    data() {
        return {
            headerBgVariant: 'secondary',
            firm_name: "${firm_name}",
            firm_name_short: "${firm_name_short}",
            edrpou: "${edrpou}",
            ipn: "${ipn}",
            tax: "${tax}",
            boss_position: "${boss_position}",
            boss_pib: "${boss_pib}",
            boss_pib_short: "${boss_pib_short}",
            work_position: "${work_position}",
            work_pib: "${work_pib}",
            work_pib_short: "${work_pib_short}",
            addr_zip_ur: "${addr_zip_ur}",
            addr_obl_ur: "${addr_obl_ur}",
            addr_city_ur: "${addr_city_ur}",
            addr_street_ur: "${addr_street_ur}",
            addr_house_ur: "${addr_house_ur}",
            addr_office_ur: "${addr_office_ur}",
            addr_zip_fact: "${addr_zip_fact}",
            addr_obl_fact: "${addr_obl_fact}",
            addr_city_fact: "${addr_city_fact}",
            addr_street_fact: "${addr_street_fact}",
            addr_house_fact: "${addr_house_fact}",
            addr_office_fact: "${addr_office_fact}",
            bank_name: "${bank_name}",
            account_number: "${account_number}",
            bank_mfo: "${bank_mfo}",
            phone_shared: "${phone_shared}",
            phone_acc: "${phone_acc}",
            phone_work: "${phone_work}",
            email_shared: "${email_shared}",
            email_acc: "${email_acc}",
            email_work: "${email_work}",
            carr_name: "${carr_name}",
            carr_city: "${carr_city}",
            carr_dep: "${carr_dep}",
            carr_pib: "${carr_pib}",
            carr_phone: "${carr_phone}",
            contract_number: "${contract_number}",
            contract_date_cyf: "${contract_date_cyf}",
            contract_date: "${contract_date}",
            contract_date_end: "${contract_date_end}",
            inv_number: "${inv_number}",
            inv_date_cyf: "${inv_date_cyf}",
            inv_date: "${inv_date}",
            inv_material: "${inv_material_1}",
            inv_charact: "${inv_charact_1}",
            inv_quantity: "${inv_quantity_1}",
            inv_price: "${inv_price_1}",
            inv_amount: "${inv_amount_1}",
            inv_count: "${inv_count}",
            amount: "${amount}",
            amount_text: "${amount_text}",
            amount_pdv: "${amount_pdv}",
            amount_pdv_text: "${amount_pdv_text}",
            pdv_minus_text: "${pdv_minus_text}",
            act_number: "${act_number}",
            act_date_cyf: "${act_date_cyf}",
            act_date: "${act_date}",
        }
    },
    methods: {
        onCopy: function (e) {
        },
        onError: function (e) {
            console.log('Помилка копіювання тексту')
        }
    }
}
</script>

<style scoped>

</style>
