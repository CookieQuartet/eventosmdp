<?php

    /*Bases*/
    define("baseUrl","http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/");
    define("defaultToken","01234567890123456789012345678901");

    /*ConsultaEventos*/
    define("consultaEventosUrl","http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaEventos");
    define("idAreaCultura", 2);

    /*ConsultaEventos*/
    define("consultaDetalleEventosUrl","http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaDetalleEvento");

    /*ConsultaEventos*/
    define("consultaAreasUrl","http://appsb.mardelplata.gob.ar/consultas/wsCalendario/RESTServiceCalendario.svc/calendario/consultaAreas");

    /*Estados Respuesta Api*/
    define ("sucessfull","Ok"); /*Llamado Exitoso*/
    define ("warning","Advertencia"); /*Hay mas resultados*/
    define ("error","Error"); /*Error en el llamado*/

    /*Tabla de Eventos Temporal*/
    define("createEventTempTable", "CREATE TABLE IF NOT EXISTS `event_temp_table` (
                                  `Id` int(11) NOT NULL AUTO_INCREMENT,
                                  `IdUser` int(11) DEFAULT NULL,
                                  `Active` int(1) NOT NULL DEFAULT '1',
                                  `Altura` varchar(100) DEFAULT NULL,
                                  `Calle` varchar(300) DEFAULT NULL,
                                  `DescripcionCalendario` varchar(3000) DEFAULT NULL,
                                  `DescripcionEvento` varchar(3000) DEFAULT NULL,
                                  `Destacado` int(1) DEFAULT NULL,
                                  `DetalleTexto` varchar(3000) DEFAULT NULL,
                                  `DireccionEvento` varchar(500) DEFAULT NULL,
                                  `FechaHoraFin` varchar(500) DEFAULT NULL,
                                  `FechaHoraInicio` varchar(500) DEFAULT NULL,
                                  `Frecuencia` varchar(300) DEFAULT NULL,
                                  `IdArea` int(11) NOT NULL,
                                  `IdCalendario` int(11) NOT NULL,
                                  `IdEvento` int(11) NOT NULL,
                                  `IdSubarea` int(11) NOT NULL,
                                  `Latitud` varchar(500) DEFAULT NULL,
                                  `Longitud` varchar(500) DEFAULT NULL,
                                  `Lugar` varchar(500) DEFAULT NULL,
                                  `NombreArea` varchar(500) NOT NULL,
                                  `NombreCalendario` varchar(500) NOT NULL,
                                  `NombreEvento` varchar(500) NOT NULL,
                                  `NombreSubAreaFormat` varchar(500) NOT NULL,
                                  `NombreSubArea` varchar(500) NOT NULL,
                                  `Precio` decimal(10,0) DEFAULT NULL,
                                  `Repetir` varchar(500) DEFAULT NULL,
                                  `RutaImagen` varchar(2000) DEFAULT NULL,
                                  `RutaImagenMiniatura` varchar(2000) DEFAULT NULL,
                                  `TodoDia` int(1) DEFAULT NULL,
                                  `ZonaHoraria` varchar(500) DEFAULT NULL,
                                  PRIMARY KEY (`Id`),
                                  UNIQUE KEY `Id_2` (`Id`),
                                  UNIQUE KEY `IdEvento` (`IdEvento`),
                                  KEY `Id` (`Id`),
                                  KEY `IdEvento_2` (`IdEvento`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;"
                            );

    define("dropEventTempTable", "DROP TABLE IF EXISTS  `event_temp_table`;");


    define("updateEventTable", "INSERT INTO `event_api` (Altura, Calle, DescripcionCalendario, DescripcionEvento, Destacado, DetalleTexto, DireccionEvento, FechaHoraFin, FechaHoraInicio, Frecuencia, IdArea, IdCalendario, IdEvento, IdSubarea, Latitud, Longitud, Lugar, NombreArea, NombreCalendario, NombreEvento, NombreSubAreaFormat, NombreSubArea, Precio, Repetir, RutaImagen, RutaImagenMiniatura, TodoDia, ZonaHoraria)
                                            SELECT event_temp_table.Altura, event_temp_table.Calle, event_temp_table.DescripcionCalendario, event_temp_table.DescripcionEvento, event_temp_table.Destacado, event_temp_table.DetalleTexto, event_temp_table.DireccionEvento, event_temp_table.FechaHoraFin, event_temp_table.FechaHoraInicio, event_temp_table.Frecuencia, event_temp_table.IdArea, event_temp_table.IdCalendario, event_temp_table.IdEvento, event_temp_table.IdSubarea, event_temp_table.Latitud, event_temp_table.Longitud, event_temp_table.Lugar, event_temp_table.NombreArea, event_temp_table.NombreCalendario, event_temp_table.NombreEvento, event_temp_table.NombreSubAreaFormat, event_temp_table.NombreSubArea, event_temp_table.Precio, event_temp_table.Repetir, event_temp_table.RutaImagen, event_temp_table.RutaImagenMiniatura, event_temp_table.TodoDia, event_temp_table.ZonaHoraria
                                            FROM `event_temp_table`
                                            ON DUPLICATE KEY
                                              UPDATE Altura = VALUES(Altura),
                                                     Calle = VALUES(Calle),
                                                     DescripcionCalendario = VALUES(DescripcionCalendario),
                                                     DescripcionEvento = VALUES(DescripcionEvento),
                                                     Destacado = VALUES(Destacado),
                                                     DetalleTexto = VALUES(DetalleTexto),
                                                     DireccionEvento = VALUES(DireccionEvento),
                                                     FechaHoraFin = VALUES(FechaHoraFin),
                                                     FechaHoraInicio = VALUES(FechaHoraInicio),
                                                     Frecuencia = VALUES(Frecuencia),
                                                     IdArea = VALUES(IdArea),
                                                     IdCalendario = VALUES(IdCalendario),
                                                     IdEvento = VALUES(IdEvento),
                                                     IdSubarea = VALUES(IdSubarea),
                                                     Latitud = VALUES(Latitud),
                                                     Longitud = VALUES(Longitud),
                                                     Lugar = VALUES(Lugar),
                                                     NombreArea = VALUES(NombreArea),
                                                     NombreCalendario = VALUES(NombreCalendario),
                                                     NombreEvento = VALUES(NombreEvento),
                                                     NombreSubAreaFormat = VALUES(NombreSubAreaFormat),
                                                     NombreSubArea = VALUES(NombreSubArea),
                                                     Precio = VALUES(Precio),
                                                     Repetir = VALUES(Repetir),
                                                     RutaImagen = VALUES(RutaImagen),
                                                     RutaImagenMiniatura = VALUES(RutaImagenMiniatura),
                                                     TodoDia = VALUES(TodoDia),
                                                     ZonaHoraria = VALUES(ZonaHoraria)
                                              ");




?>