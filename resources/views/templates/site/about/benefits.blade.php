@extends('layouts.site.main')

@section('content')
    <main>
        <div class="container py-5">
            <div class="row">
                @include('layouts.site.include.menu.about')
                <div class="col-lg-9 px-lg-0 px-4">
                    <div class="block-75">
                        <p class="text-black-black">Преимущества системы ВКР-СМАРТ.РФ</p>
                        <ul class="text-black fs-14">
                            <li class="pb-3">ВКР-СМАРТ.РФ является универсальным специализированным программным продуктом,
                                предназначенным для систематизации и грамотного хранения работ учебного заведения (ВКР),
                                их проверки на заимствования в ЭБС и по другим источникам, создания и ведения
                                электронных портфолио достижений, а соответственно полного выполнения требований
                                законодательства.
                            </li>
                            <li class="pb-3">Комплексный подход к решению вопроса позволяет использовать систему
                                максимально эффективно и экономить средства на приобретении отдельных
                                неспециализированных сервисов либо разработке собственной платформы и интеграции ее с
                                другим ПО.
                            </li>
                            <li class="pb-3">Возможность использовать все функции системы в комплексе или выбирать одно
                                из решений.
                            </li>
                            <li class="pb-3">Система модулей ВКР-СМАРТ.РФ, работающих обособленно друг от друга, в том
                                числе в автономном режиме, позволяет обеспечить высокую скорость работы как системы в
                                целом, так и отдельных модулей.
                            </li>
                            <li class="pb-3">Продуманная и интуитивно понятная система размещения и хранения работ,
                                ведения электронных портфолио, позволяющая в дальнейшем существенно сократить время на
                                подготовку различных отчетов как для руководства, так и для контролирующих органов по
                                любым важным параметрам.
                            </li>
                            <li class="pb-3">Гибкая система настроек доступа для сотрудников учебного заведения.</li>
                            <li class="pb-3">Современные уникальные методы поиска заимствований. В ПО внедрены и
                                эффективно применяются специально разработанные методы поиска заимствований с учетом
                                морфологии и фрагментирования.
                            </li>
                            <li class="pb-3">Электронное портфолио достижений — уникальный инструмент, который позволяет
                                обучающимся и сотрудникам учебного заведения вести архив любых своих работ. Сервис
                                разработан в целях соблюдения условий для выполнения ФГОС ВО и ФГОС СПО, внедрения
                                системы учета внеучебных достижений, формирования электронного портфолио сотрудников и
                                обучающихся. Этот функционал позволяет активно вовлекать студентов в работу с системой
                                ВКР-СМАРТ.РФ. Таким образом, удается наладить загрузку текстов на платформу и их
                                дальнейшую обработку максимально эффективно.
                            </li>
                            <li class="pb-3">Эффективный инструмент для взаимодействия научного руководителя и студента.
                                Осуществление проверки текстов не только на заимствования, но и на корректность
                                составления цитат (в соответствии с установленными требованиями к цитированию),
                                формирование детализированных отчетов.
                            </li>
                            <li class="pb-3">Соблюдение законодательства в сфере авторских прав и безопасность хранения
                                работ — гарантия охраны текстов от доступа третьих лиц. Это важное и необходимое условие
                                размещения ВКР в ЭБС, оно продиктовано, прежде всего, тем, что любая работа создается
                                творческим трудом обучающегося или сотрудника, а, значит, и охраняется российским
                                законодательством. В служебных целях учебного заведения (выполнение приказа № 636)
                                размещение работ рекомендуется оформлять с обучающимися или сотрудниками в виде
                                письменного согласия. Предоставление открытого доступа к работам третьим лицам потребует
                                от учебного заведения заключение авторского договора и выплаты вознаграждения. Именно
                                эти правовые нормы обязывают обеспечивать только закрытый доступ к работам в нашей
                                системе. Однако модификация нашего ПО предусматривает возможность создания любых
                                индивидуальных решений, и если учебное заведение предпочитает предоставлять открытый
                                (или ограниченный) доступ к размещенным работам и имеет на это правовые основания, наша
                                компания также готова оказать данную услугу.
                            </li>
                            <li class="pb-3">Возможность осуществления доработки программного обеспечения по пожеланиям
                                клиента. Ваше мнение очень важно для нас!
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-xl-2 col-3 d-md-block d-none">
                                <div class="bg-green br-20 p-4 d-flex align-items-center justify-content-center">
                                    <img src="/images/start.png" alt="">
                                </div>
                            </div>
                            <div class="col-md-9 col-12">
                                <div class="bg-green br-20 p-4">
                                    <h6 class="lh-28">Все программные продукты компании "PROFобразование"
                                        разрабатываются на основе передовых программ и технологий, мощные
                                        серверы — залог надежности системы, высокого качества наших услуг и вашего
                                        спокойствия!</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
