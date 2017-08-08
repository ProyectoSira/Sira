
INSERT INTO `tbl_tipo_anormalidad` (`COD_TIP_ANORM`, `NOM_ANORM`) VALUES
(1, 'Jornada Pedagogica'),
(2, 'Paro');

--
-- Volcado de datos para la tabla `tbl_tipo_documento`
--

INSERT INTO `tbl_tipo_documento` (`ID_TIP_DOC`, `SIGLA_DOC`, `NOM_TIP_DOC`) VALUES
(1, 'TI', 'TARJETA DE IDENTIDAD'),
(2, 'CC', 'CEDULA DE CIUDADANIA'),
(3, 'CE', 'CEDULA DE EXTRANJERIA');

--
-- Volcado de datos para la tabla `tbl_tipo_empleado`
--

INSERT INTO `tbl_tipo_empleado` (`ID_TIP_EMP`, `NOM_CARGO_EMP`) VALUES
(1, 'COORDINADOR'),
(2, 'SECRETARIA'),
(3, 'PROFESOR');

--
-- Volcado de datos para la tabla `tbl_tipo_sancion`
--

INSERT INTO `tbl_tipo_sancion` (`COD_TIP_SANC`, `NOM_SANC`) VALUES
(1, 'ANOTACION'),
(2, 'CITACION');

--
-- Volcado de datos para la tabla `tbl_tip_jornada`
--

INSERT INTO `tbl_tip_jornada` (`ID_TIP_JORN`, `NOM_JORNADA`) VALUES
(1, 'MAÑANA'),
(2, 'TARDE');

INSERT INTO `tbl_rol_usuario` (`COD_ROL_USU`, `NOM_ROL_USU`) VALUES
(1, 'Coordinador'),
(2, 'Profesor'),
(3, 'Secretaria');




INSERT INTO `tbl_periodo` (`COD_PER`, `NUM_PER`, `NOM_PER`, `FECH_INI_PER`, `FECH_FIN_PER`) VALUES
(1, 1, 'PRIMERO', '2017-01-16', '2017-04-07'),
(2, 2, 'SEGUNDO', '2017-04-17', '2017-06-16'),
(3, 3, 'TERCERO', '2017-06-19', '2017-09-22'),
(4, 4, 'CUARTO', '2017-09-25', '2017-11-24');

--
-- Volcado de datos para la tabla `tbl_piso`
--

INSERT INTO `tbl_piso` (`ID_PISO`, `NUM_PISO`) VALUES
(1, '1'),
(2, '2'),
(3, '3');


INSERT INTO `tbl_opcion_menu` (`ID_OPC_MENU`, `NOM_OPC_MENU`, `ULR_MENU`, `ICONO`) VALUES
(1, 'Matrícula', 'acudiente', 'lnr lnr-graduation-hat'),
(2, 'Materias', 'area', 'lnr lnr-layers'),
(3, 'Grupos', 'grado', 'lnr lnr-link'),
(4, 'Empleados', 'empleado', 'lnr lnr-users'),
(5, 'Grupo de Estudio', 'asignacion', 'lnr lnr-sync'),
(6, 'Periodos', 'periodo', 'lnr lnr-calendar-full'),
(7, 'Programación', 'horario', 'lnr lnr-line-spacing'),
(8, 'Llegadas Tarde', 'llegadatarde', 'lnr lnr-clock'),
(9, 'Asistencia', 'asistencia', 'lnr lnr-spell-check'),
(10, 'Reportes', 'reportes', 'lnr lnr-list'),
(11, 'Sanciones', 'sancion', 'lnr lnr-warning'),
(12, 'Planeación', 'planeacion', 'lnr lnr-paperclip'),
(13, 'Anormalidades', 'anormalidad', 'lnr lnr-hourglass'),
(14, 'Asignar Usuario', 'usuario', 'lnr lnr-user'),
(15, 'Adjuntar Excusa', 'excusa', 'lnr lnr-paperclip');


INSERT INTO `tbl_jornada` (`COD_JOR`, `ID_TIP_JORN`, `HOR_INI_JOR`, `HOR_FIN_JOR`) VALUES
(1, 1, '06:00:00', '11:45:00'),
(2, 2, '12:00:00', '18:00:00');

INSERT INTO `tbl_empleado` (`DOC_EMP`, `ID_TIP_DOC`, `ID_TIP_EMP`, `NOM1_EMP`, `NOM2_EMP`, `APE1_EMP`, `APE2_EMP`, `CIU_EMP`, `FECH_NAC_EMP`, `DIR_EMP`, `EMAIL_EMP`, `TEL1_EMP`, `TEL2_EMP`) VALUES
(7653674, 2, 3, 'CLAUDIA', '', 'HERRERA', '', 2, '1989-09-20', 'MEXICO', 'CLAUDIA@GMAIL.COM', '567834', '987654354'),
(43445563, 2, 3, 'JIMMY', '', 'MOSQUERA', '', 2, '1989-06-13', 'NOSE', 'MOSQUERITA@GMAIL.COM', '5656454', '6455543543'),
(45676543, 2, 3, 'LIGIA', 'MARIA', 'MONTOYA', '', 2, '1994-11-22', 'NPI', 'LIMOMO@GMAIL.COM', '3454334', ''),
(456787634, 2, 3, 'LUIS', 'GUILLERMO', 'GUTIERREZ', '', 2, '1990-03-13', 'EVG', 'JFMEJIA048@MISENA.EDU.CO', '345654', '345654'),
(1035419438, 2, 2, 'GLORIA', '', 'RAMIREZ', '', 2, '1989-06-13', 'BARRIO ANT.', 'TOMAS@GMAIL.COM', '2345665', '7654334565');

INSERT INTO `tbl_acudiente` (`DOC_ACU`, `ID_TIP_DOC`, `NOM1_ACU`, `NOM2_ACU`, `APE1_ACU`, `APE2_ACU`, `FECH_NAC_ACU`, `EMAIL_ACU`, `CIU_ACU`, `DIR_ACU`, `TEL1_ACU`, `TEL2_ACU`) VALUES
(71234567, 2, 'WILSON', '', 'MEJIA', 'SANCHEZ', '1989-11-14', 'WILSON@GMAIL.COM', 2, 'BUENAVISTA', 3433849, 3017659662),
(765433456, 2, 'DIEGO', '', 'NORREA', '', '1990-07-17', 'DIEGON@OUTLOOK.ES', 20, 'PACHELI', 7654345, 567887654),
(987654321, 2, 'JOE', '', 'HURTADO', 'PLATA', '1999-02-16', 'JOE@GMAIL.COM', 2, 'BELEN', 2343234, 765432123);


--
-- Volcado de datos para la tabla `tbl_estudiante`
--

INSERT INTO `tbl_estudiante` (`DOC_EST`, `ID_TIP_DOC_EST`, `DOC_ACU`, `NOM1_EST`, `NOM2_EST`, `APE1_EST`, `APE2_EST`, `FECH_NAC_EST`, `CIU_EST`, `DIR_EST`, `TEL1_EST`, `TEL2_EST`, `EMAIL_EST`, `GRADO_EST`, `ESTADO_ACU`) VALUES
(9876553, 2, 765433456, 'ANGELA', 'MARIA', 'GONZALES', '', '2002-10-16', 2, 'LAMANO', '3457654', '8765435456', 'ANGELITA@GMAIL.COM', 'SEXTO', 'Activo'),
(11267584, 1, 71234567, 'DANIEL', '', 'GARCIA', '', '2013-05-01', 2, 'CRA 92 - 10', '345678', '', 'DANIEL@GMAIL.COM', 'PRIMERO', 'Activo'),
(34545644, 2, 987654321, 'ESTEFANIA', '', 'CANO', '', '2000-12-24', 2, 'SANCRIS', '5645454', '5654543433', 'ESTEFI@GMAIL.COM', 'SEXTO', 'Activo'),
(43445678, 2, 71234567, 'JUAN', 'ESTEBAN', 'CANO', '', '1999-02-07', 2, 'BUENAVISTA', '3433849', '234454545', 'JUANCANO@GMAIL.COM', 'SEXTO', 'Activo'),
(45554543, 3, 987654321, 'JUAN', 'DAVID', 'MARULANDA', '', '2010-06-23', 2, 'SANJAVIER', '4565454', '654764443', 'MARULANDA@GMAIL.COM', 'QUINTO', 'Activo'),
(45644333, 2, 987654321, 'JUAN', 'DAVID', 'SOTO', '', '2004-06-23', 2, 'ALTAVISTA', '7654534', '4546433222', 'GAFUANDA@OUTLOOK.ES', 'SEXTO', 'Activo'),
(76545673, 2, 765433456, 'SANTIAGO', '', 'SOTO', '', '2004-05-03', 2, 'ALTAVISTA', '456654', '454654324', 'GATO@GMAIL.COM', 'QUINTO', 'Activo'),
(76567765, 2, 765433456, 'JUAN', 'CAMILO', 'LOPEZ', '', '2003-11-10', 2, 'SANCRIS', '5565454', '867566564', 'BARNIE@GMAIL.COM', 'QUINTO', 'Activo'),
(234567654, 1, 987654321, 'SEBASTIAN', '', 'BUILES', '', '2013-05-14', 2, 'CASTILLA', '23456', '7867565', 'BUILES@HOTMAIL.COM', 'TERCERO', 'Activo'),
(344556765, 2, 765433456, 'CAMILO', '', 'RIOS', 'ALVAREZ', '1990-02-13', 2, 'ALTAVISTA', '2345654', '3456765', 'RIOS@GMAIL.COM', 'SEXTO', 'Activo'),
(545637238, 2, 987654321, 'DANIEL', '', 'AGUDELO', 'MAZO', '2013-01-14', 2, 'PICACHO', '545667876', '766545787', 'DANIELITO@GMAIL.COM', 'SEXTO', 'Activo'),
(654567655, 2, 765433456, 'MATEO', '', 'TORRES', '', '2010-06-14', 2, 'MIRAMAR', '3456554', '456576543', 'MORZA@GMAIL.COM', 'PRIMERO', 'Activo'),
(1029384384, 2, 71234567, 'DIEGO', 'RAUL', 'ORTEGA', 'RAMIREZ', '2002-02-01', 2, 'WDFDF-232-232', '2324567', '1234234', 'DCDD@GMAIL.COM', 'PRIMERO', 'Activo'),
(1152469105, 2, 71234567, 'JUAN', 'FERNANDO', 'MEJIA', '', '1999-02-07', 2, 'BUENAVISTA', '3433849', '3216910727', 'JUANFER@GMAIL.COM', 'TERCERO', 'Activo');

--
-- Volcado de datos para la tabla `tbl_grado`
--

INSERT INTO `tbl_grado` (`COD_GRADO`, `NOM_GRADO`) VALUES
(1, 'PRIMERO'),
(2, 'SEGUNDO'),
(3, 'TERCERO'),
(4, 'CUARTO'),
(5, 'QUINTO'),
(6, 'SEXTO'),
(7, 'SEPTIMO');


INSERT INTO `tbl_sancion` (`COD_SANC`, `COD_TIP_SANC`, `DOC_EST`, `DOC_EMP`, `RAZON_SANC`, `FECH_SANC`, `ESTADO`) VALUES
(1, 1, 1152469105, 1035419438, 'Llegada tarde a clase', '2017-05-07', 0);

INSERT INTO `tbl_usuario` (`ID_USU`, `NOM_USU`, `PASS_USU`, `DOC_EMP`, `ROL_USU`) VALUES
(1, 'Gloria', '54321', 1035419438, 3),
(2, 'Luisgui', '12345', 456787634, 2);

INSERT INTO `tbl_aula` (`COD_AULA`, `NUM_AULA`, `ID_PISO`) VALUES
(1, '101', 1),
(2, '102', 1),
(3, '205', 2),
(4, '206', 2),
(5, '301', 3),
(6, '302', 3);

INSERT INTO `tbl_area` (`COD_AREA`, `NOM_AREA`, `DOC_EMP`) VALUES
(1, 'CIENCIAS SOCIALES', 456787634);

INSERT INTO `tbl_asignatura` (`COD_ASIG`, `NOM_ASIG`, `COD_AREA`) VALUES
(1, 'SOCIALES', 1);


INSERT INTO `tbl_asignacion_rol` (`ID_ASIGNA_OPC_MENU`, `ROL_USU`, `ID_OPC_MENU`) VALUES
(1, 2, 7),
(2, 2, 9),
(3, 2, 10),
(4, 2, 11),
(5, 2, 12),
(6, 3, 1),
(7, 3, 2),
(8, 3, 3),
(9, 3, 4),
(10, 3, 5),
(11, 3, 6),
(12, 3, 13),
(13, 1, 1),
(14, 1, 2),
(15, 1, 3),
(16, 1, 4),
(18, 1, 6),
(19, 1, 8),
(21, 1, 10),
(22, 1, 11),
(23, 1, 13),
(24, 1, 14),
(25, 1, 15);

INSERT INTO `tbl_grupo` (`COD_GRUPO`, `NUM_GRUPO`, `COD_GRADO`, `DOC_EMP`, `TBL_JORNADA_COD_JOR`) VALUES
(1, 1, 1, 7653674, 1),
(2, 2, 1, 43445563, 1),
(4, 2, 2, 456787634, 1),
(5, 1, 3, 1035419438, 1),
(6, 2, 3, 7653674, 1),
(7, 1, 4, 43445563, 1),
(8, 2, 4, 45676543, 1),
(9, 1, 5, 456787634, 1),
(10, 2, 5, 1035419438, 2),
(11, 1, 6, 7653674, 2),
(12, 2, 6, 43445563, 2),
(13, 1, 2, 45676543, 1);
INSERT INTO `tbl_grupo_estudio` (`ID_EST_GRUP`, `DOC_EST`, `COD_GRUPO`) VALUES
(1, 1029384384, 1),
(2, 654567655, 1),
(3, 11267584, 1),
(4, 545637238, 11),
(5, 344556765, 11),
(6, 45644333, 11),
(7, 43445678, 11),
(8, 34545644, 11),
(9, 9876553, 11);
INSERT INTO `tbl_calendario` (`COD_CAL`, `AÑO_CAL`, `COD_PER`) VALUES
(1, '2017', 1);
INSERT INTO `tbl_programacion` (`COD_PROGRA`, `DOC_EMP`, `COD_ASIG`, `COD_AULA`, `HORA_INI`, `HORA_FIN`, `DIA_SEM`, `COD_CAL`, `COD_GRUPO`) VALUES
(1, 456787634, 1, 3, '12:00', '12:50', 'MARTES', 1, 7);
