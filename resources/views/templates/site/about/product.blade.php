@extends('layouts.site.main')

@section('content')
    <main>
        <div class="container py-5">
            <div class="row">
                @include('layouts.site.include.menu.about')
                <div class="col-lg-9 px-lg-0 px-4">
                    <div class="block-75">
                        <p class="fw-700">ВКР-СМАРТ.РФ — универсальная платформа, предназначенная для проверки на
                            заимствования и системного хранения выпускных квалификационных и других работ обучающихся, а
                            также для создания единой базы электронного портфолио образовательной организации.</p>
                        <p class="fs-14 lh-17">Использование платформы ВКР-СМАРТ.РФ в повседневной работе учебного
                            заведения позволяет существенно сэкономив средства, повысить качество работ обучающихся и
                            сотрудников, сделав образовательный процесс удобнее и лучше. Система подходит для хранения и
                            проверки работ любых образовательных организаций, как ВО, так и СПО.</p>
                        <p class="mb-2 pt-3 text-black-black">Ключевые особенности продукта:</p>
                        <ul class="text-black fs-14">
                            <li class="pb-1">Комплексность системы — от хранения работ обучающихся, до возможности
                                создания ЭИОС на базе ВКР-СМАРТ.РФ;
                            </li>
                            <li class="pb-1">Уникальные модули системы (модуль хранения работ, модуль портфолио, отчеты
                                по работам и портфолио), легко интегрируемые в любую другую единую
                                информационно-образовательную среду организации через предоставляемый широкий спектр
                                API;
                            </li>
                            <li class="pb-1">Автоматическая или ручная проверка на заимствования с мгновенным
                                формированием отчета и справки о заимствованиях в работах и его автосохранение;
                            </li>
                            <li class="pb-1">Бесшовный переход из электронно-библиотечной системы ЭБС IPR SMART в личный
                                кабинет на платформе ВКР-СМАРТ.РФ;
                            </li>
                            <li class="pb-1">Обеспечение синхронного и асинхронного взаимодействия между участниками
                                образовательного процесса;
                            </li>
                            <li class="pb-1">Полное соответствие всем требованиям ФГОС ВО и СПО;</li>
                            <li class="pb-1">Адаптируемость под ваши требования и задачи;</li>
                            <li class="pb-1">Простота и удобство использования.</li>
                        </ul>
                        <p class="mb-2 pt-3 text-black-black">Возможности платформы для хранения и проверки ВКР
                            образовательной организации:</p>
                        <ul class="text-black fs-14 text-black-black">
                            <li class="pb-1">Брендирование страниц платформы фирменным стилем учебного заведения;</li>
                            <li class="pb-1">Индивидуальные настройки структуры платформы под потребности учебного
                                заведения;
                            </li>
                            <li class="pb-1">Возможность генерировать любое количество учетных записей пользователей;
                            </li>
                            <li class="pb-1">Безлимитное количество проверок;</li>
                            <li class="pb-1">Бесплатное хранение работ в течение 5 лет;</li>
                            <li class="pb-1">Передача полного архива работ в случае смены репозитория;</li>
                            <li class="pb-1">Возможность работы платформы на отдельном выделенном сервере;</li>
                            <li class="pb-1">Зеркалирование работ и гарантированная безопасность хранения;</li>
                            <li class="pb-1">Бесплатные обновления индексной базы, по которой ведётся проверка на
                                заимствования (источники, интернет, ЭБС IPR SMART, все работы платформы ВКР-СМАРТ);
                            </li>
                            <li class="pb-1">Соблюдение ФЗ «О персональных данных»;</li>
                            <li class="pb-1">Использование только российского ПО в российских data-центрах.</li>
                        </ul>
                        <p class="mb-2 pt-3 text-black-black">Для комфортной работы с платформой ВКР-СМАРТ.РФ мы:</p>
                        <ul class="text-black fs-14">
                            <li class="pb-1">Создали гибкую систему настройки платформы и профилей в соответствии с
                                потребностями учебного заведения;
                            </li>
                            <li class="pb-1">Обеспечили возможность модерации работ студентов ответственными
                                сотрудниками;
                            </li>
                            <li class="pb-1">Разработали систему комментирования работ, прикрепления отзывов и рецензий
                                к работам научными руководителями и преподавателями;
                            </li>
                            <li class="pb-1">Предусмотрели возможность загрузки работ любыми типами пользователей
                                (администратором, сотрудниками, обучающимися);
                            </li>
                            <li class="pb-1">Внедрили возможность взаимодействия студентов и преподавателей;</li>
                            <li class="pb-1">Открыли профиль «Проверяющий» для предоставления необходимых данных в
                                контролирующие органы;
                            </li>
                            <li class="pb-1">Устанавливаем связи между работами и электронным портфолио обучающихся,
                                позволяющие сохранять ресурсы учебного заведения в едином информационном пространстве;
                            </li>
                            <li class="pb-1">Развиваем и предоставляем широкий спектр API для интеграции системы в ЭИОС
                                учебного заведения;
                            </li>
                            <li class="pb-1">Используем высокопроизводительные собственные серверы, позволяющие хранить
                                большие объемы данных;
                            </li>
                            <li class="pb-1">Предоставляем широкие возможности для формирования отчётов по работам и
                                портфолио в разрезе различных параметров (год выпуска, УГНП, подразделения учебного
                                заведения, данные студента и. т. д.), выгрузку данных в сводном табличном виде в
                                документе Microsoft Excel.
                            </li>
                        </ul>
                        <p class="mb-2 pt-3 text-black-black">Выгоды использования платформы:</p>
                        <ul class="text-black fs-14">
                            <li class="pb-1">Обеспечение государственной политики в области образования и повышение
                                цифровизации учебного заведения;
                            </li>
                            <li class="pb-1">Оптимизация временных, трудовых и финансовых затрат;</li>
                            <li class="pb-1">Возможность использовать комплекс функций, вместо разрозненных решений;
                            </li>
                            <li class="pb-1">Быстрая интеграция в ЭИОС стабильных и проверенных сервисов;</li>
                            <li class="pb-1">При отсутствии своей ЭИОС — возможность обеспечить ее наличие на базе
                                ВКР-СМАРТ.РФ;
                            </li>
                            <li class="pb-1">Гибкий перечень настроек позволяет максимально адаптировать работу
                                платформы для каждого конкретного случая;
                            </li>
                            <li class="pb-1">Полное соответствие платформы требованиям законодательства;</li>
                            <li class="pb-1">Размещенные на платформе материалы полностью защищены от копирования.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

