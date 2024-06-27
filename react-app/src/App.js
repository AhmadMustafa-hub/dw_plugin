import React, { useEffect, useState } from "react";
import apiFetch from "@wordpress/api-fetch";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from "recharts";
import "./App.css";
import { SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

const App = () => {
  const [data, setData] = useState([]);
  const [range, setRange] = useState("7");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      const endDate = new Date().toISOString().split("T")[0];
      const startDate = new Date();
      startDate.setDate(startDate.getDate() - parseInt(range) + 1);
      const formattedStartDate = startDate.toISOString().split("T")[0];
      const baseUrl =
        window.location.origin +
        window.location.pathname.split("/wp-admin/")[0];
      const apiUrl = `${baseUrl}/wp-json/dw/v1/data`;
      try {
        const response = await apiFetch({
          path: `${apiUrl}?start_date=${formattedStartDate}&end_date=${endDate}`,
          headers: { "X-WP-Nonce": window.wpApiSettings.nonce },
        });
        setData(response);
      } catch (error) {
        console.error("There was an error fetching the data", error);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [range]);

  const handleChangeRange = (value) => {
    setRange(value);
  };

  return (
    <div className="App">
      <SelectControl
        value={range}
        options={[
          { label: __("Last 7 Days", "dw-plugin"), value: "7" },
          { label: __("Last 14 Days", "dw-plugin"), value: "14" },
          { label: __("Last 30 Days", "dw-plugin"), value: "30" },
        ]}
        onChange={handleChangeRange}
      />
      {loading ? (
        <p>{__("Loading data...", "dw-plugin")}</p>
      ) : data.length > 0 ? (
        <ResponsiveContainer width="100%" height={400}>
          <LineChart data={data}>
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="date" />
            <YAxis />
            <Tooltip />
            <Line
              type="monotone"
              dataKey="value"
              stroke="#8884d8"
              activeDot={{ r: 8 }}
            />
          </LineChart>
        </ResponsiveContainer>
      ) : (
        <p className="no-data">No Data Available</p>
      )}
    </div>
  );
};

export default App;
