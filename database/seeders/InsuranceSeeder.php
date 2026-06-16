<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    public function run(): void
    {
        $insurances = [
            [
                'name' => 'Plan Empresarial Premium',
                'provider' => 'GNP Seguros',
                'policy_number' => 'POL-2026-001234',
                'coverage_type' => 'Premium',
                'coverage_percentage' => 90.00,
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'phone' => '800 123 4567',
                'email' => 'empresarial@gnp.com.mx',
                'description' => 'Cobertura premium para empleados corporativos. Incluye hospitalización, consultas de especialidad, estudios de laboratorio y medicamentos.',
                'status' => 1,
            ],
            [
                'name' => 'Seguro Familiar Básico',
                'provider' => 'AXA Seguros',
                'policy_number' => 'POL-2026-005678',
                'coverage_type' => 'Básica',
                'coverage_percentage' => 60.00,
                'start_date' => '2026-03-15',
                'end_date' => '2027-03-14',
                'phone' => '800 900 1234',
                'email' => 'familiar@axa.com.mx',
                'description' => 'Plan básico de cobertura familiar para consultas generales y emergencias.',
                'status' => 1,
            ],
            [
                'name' => 'Cobertura Completa Salud',
                'provider' => 'MetLife México',
                'policy_number' => 'POL-2026-009012',
                'coverage_type' => 'Completa',
                'coverage_percentage' => 85.00,
                'start_date' => '2026-02-01',
                'end_date' => '2027-01-31',
                'phone' => '800 638 5433',
                'email' => 'salud@metlife.com.mx',
                'description' => 'Cobertura completa que incluye consultas, hospitalización, cirugías, maternidad y rehabilitación.',
                'status' => 1,
            ],
            [
                'name' => 'Plan Dental Plus',
                'provider' => 'Dentegra',
                'policy_number' => 'POL-2026-003456',
                'coverage_type' => 'Dental',
                'coverage_percentage' => 75.00,
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'phone' => '800 336 8347',
                'email' => 'atencion@dentegra.com.mx',
                'description' => 'Cobertura dental que incluye limpiezas, extracciones, endodoncias y ortodoncia básica.',
                'status' => 1,
            ],
            [
                'name' => 'Seguro Oftalmológico Visión',
                'provider' => 'Seguros Monterrey',
                'policy_number' => 'POL-2026-007890',
                'coverage_type' => 'Oftalmológica',
                'coverage_percentage' => 70.00,
                'start_date' => '2025-06-01',
                'end_date' => '2026-05-31',
                'phone' => '800 777 8899',
                'email' => 'vision@monterrey.com.mx',
                'description' => 'Cobertura oftalmológica para consultas, lentes graduados y cirugía láser.',
                'status' => 0,
            ],
            [
                'name' => 'Plan Maternidad Integral',
                'provider' => 'Zurich Seguros',
                'policy_number' => 'POL-2026-004321',
                'coverage_type' => 'Maternidad',
                'coverage_percentage' => 80.00,
                'start_date' => '2026-04-01',
                'end_date' => '2027-03-31',
                'phone' => '800 268 0000',
                'email' => 'maternidad@zurich.com.mx',
                'description' => 'Plan integral de maternidad que cubre control prenatal, parto, cesárea y cuidados neonatales.',
                'status' => 1,
            ],
            [
                'name' => 'Convenio Universitario',
                'provider' => 'MAPFRE México',
                'policy_number' => 'POL-2026-006543',
                'coverage_type' => 'Intermedia',
                'coverage_percentage' => 65.00,
                'start_date' => '2026-08-01',
                'end_date' => '2027-07-31',
                'phone' => '800 627 3730',
                'email' => 'universidades@mapfre.com.mx',
                'description' => 'Convenio especial para estudiantes universitarios con cobertura intermedia en consultas y hospitalización.',
                'status' => 1,
            ],
            [
                'name' => 'Seguro Ejecutivo Gold',
                'provider' => 'Allianz México',
                'policy_number' => 'POL-2026-008765',
                'coverage_type' => 'Premium',
                'coverage_percentage' => 95.00,
                'start_date' => '2026-01-15',
                'end_date' => '2027-01-14',
                'phone' => '800 400 5000',
                'email' => 'ejecutivo@allianz.com.mx',
                'description' => 'Seguro ejecutivo de alta gama con cobertura internacional, segunda opinión médica y traslado aéreo.',
                'status' => 1,
            ],
        ];

        foreach ($insurances as $insurance) {
            Insurance::create($insurance);
        }
    }
}
