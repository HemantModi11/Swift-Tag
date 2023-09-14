import { Helmet } from 'react-helmet-async';
// @mui
import { Grid, Button, Container, Stack, Typography } from '@mui/material';
// components
import Iconify from '../components/iconify';

// ----------------------------------------------------------------------

export default function FinePage() {
  return (
    <>
      <Helmet>
        <title> Dashboard: Fine</title>
      </Helmet>

      <Container>
        <Stack direction="row" alignItems="center" justifyContent="space-between" mb={5}>
          <Typography variant="h4" gutterBottom>
            Fine
          </Typography>
        </Stack>
      </Container>
    </>
  );
}
